<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\PaymentType;
use App\Models\FuelService;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentTypeFuelServicesTest extends TestCase
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
    public function it_gets_payment_type_fuel_services()
    {
        $paymentType = PaymentType::factory()->create();
        $fuelServices = FuelService::factory()
            ->count(2)
            ->create([
                'payment_type_id' => $paymentType->id,
            ]);

        $response = $this->getJson(
            route('api.payment-types.fuel-services.index', $paymentType)
        );

        $response->assertOk()->assertSee($fuelServices[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_payment_type_fuel_services()
    {
        $paymentType = PaymentType::factory()->create();
        $data = FuelService::factory()
            ->make([
                'payment_type_id' => $paymentType->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.payment-types.fuel-services.store', $paymentType),
            $data
        );

        unset($data['created_by_id']);
        unset($data['approved_by_id']);
        unset($data['notes']);

        $this->assertDatabaseHas('fuel_services', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $fuelService = FuelService::latest('id')->first();

        $this->assertEquals($paymentType->id, $fuelService->payment_type_id);
    }
}
