<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Presence;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserPresencesTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_user_presences()
    {
        $user = User::factory()->create();
        $presences = Presence::factory()
            ->count(2)
            ->create([
                'approved_by_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.presences.index', $user));

        $response->assertOk()->assertSee($presences[0]->image_in);
    }

    /**
     * @test
     */
    public function it_stores_the_user_presences()
    {
        $user = User::factory()->create();
        $data = Presence::factory()
            ->make([
                'approved_by_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.presences.store', $user),
            $data
        );

        unset($data['image_in']);
        unset($data['image_out']);
        unset($data['lat_long_in']);
        unset($data['lat_long_out']);
        unset($data['approved_by_id']);

        $this->assertDatabaseHas('presences', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $presence = Presence::latest('id')->first();

        $this->assertEquals($user->id, $presence->approved_by_id);
    }
}
