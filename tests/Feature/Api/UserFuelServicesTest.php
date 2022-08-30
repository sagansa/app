<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\FuelService;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserFuelServicesTest extends TestCase
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
    public function it_gets_user_fuel_services()
    {
        $user = User::factory()->create();
        $fuelServices = FuelService::factory()
            ->count(2)
            ->create([
                'approved_by_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.fuel-services.index', $user)
        );

        $response->assertOk()->assertSee($fuelServices[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_user_fuel_services()
    {
        $user = User::factory()->create();
        $data = FuelService::factory()
            ->make([
                'approved_by_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.fuel-services.store', $user),
            $data
        );

        unset($data['created_by_id']);
        unset($data['approved_by_id']);
        unset($data['notes']);

        $this->assertDatabaseHas('fuel_services', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $fuelService = FuelService::latest('id')->first();

        $this->assertEquals($user->id, $fuelService->approved_by_id);
    }
}
