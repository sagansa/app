<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Vehicle;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserVehiclesTest extends TestCase
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
    public function it_gets_user_vehicles()
    {
        $user = User::factory()->create();
        $vehicles = Vehicle::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.vehicles.index', $user));

        $response->assertOk()->assertSee($vehicles[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_user_vehicles()
    {
        $user = User::factory()->create();
        $data = Vehicle::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.vehicles.store', $user),
            $data
        );

        $this->assertDatabaseHas('vehicles', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $vehicle = Vehicle::latest('id')->first();

        $this->assertEquals($user->id, $vehicle->user_id);
    }
}
