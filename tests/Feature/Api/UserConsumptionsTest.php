<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Consumption;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserConsumptionsTest extends TestCase
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
    public function it_gets_user_consumptions()
    {
        $user = User::factory()->create();
        $consumptions = Consumption::factory()
            ->count(2)
            ->create([
                'approved_by_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.consumptions.index', $user)
        );

        $response->assertOk()->assertSee($consumptions[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_user_consumptions()
    {
        $user = User::factory()->create();
        $data = Consumption::factory()
            ->make([
                'approved_by_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.consumptions.store', $user),
            $data
        );

        $this->assertDatabaseHas('consumptions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $consumption = Consumption::latest('id')->first();

        $this->assertEquals($user->id, $consumption->approved_by_id);
    }
}
