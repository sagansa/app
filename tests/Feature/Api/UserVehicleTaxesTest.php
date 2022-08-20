<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\VehicleTax;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserVehicleTaxesTest extends TestCase
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
    public function it_gets_user_vehicle_taxes()
    {
        $user = User::factory()->create();
        $vehicleTaxes = VehicleTax::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.vehicle-taxes.index', $user)
        );

        $response->assertOk()->assertSee($vehicleTaxes[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_user_vehicle_taxes()
    {
        $user = User::factory()->create();
        $data = VehicleTax::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.vehicle-taxes.store', $user),
            $data
        );

        unset($data['user_id']);

        $this->assertDatabaseHas('vehicle_taxes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $vehicleTax = VehicleTax::latest('id')->first();

        $this->assertEquals($user->id, $vehicleTax->user_id);
    }
}
