<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Hygienic;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserHygienicsTest extends TestCase
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
    public function it_gets_user_hygienics()
    {
        $user = User::factory()->create();
        $hygienics = Hygienic::factory()
            ->count(2)
            ->create([
                'updated_by_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.hygienics.index', $user));

        $response->assertOk()->assertSee($hygienics[0]->status);
    }

    /**
     * @test
     */
    public function it_stores_the_user_hygienics()
    {
        $user = User::factory()->create();
        $data = Hygienic::factory()
            ->make([
                'updated_by_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.hygienics.store', $user),
            $data
        );

        $this->assertDatabaseHas('hygienics', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $hygienic = Hygienic::latest('id')->first();

        $this->assertEquals($user->id, $hygienic->updated_by_id);
    }
}
