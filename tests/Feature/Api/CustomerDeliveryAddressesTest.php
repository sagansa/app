<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Customer;
use App\Models\DeliveryAddress;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerDeliveryAddressesTest extends TestCase
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
    public function it_gets_customer_delivery_addresses()
    {
        $customer = Customer::factory()->create();
        $deliveryAddresses = DeliveryAddress::factory()
            ->count(2)
            ->create([
                'customer_id' => $customer->id,
            ]);

        $response = $this->getJson(
            route('api.customers.delivery-addresses.index', $customer)
        );

        $response->assertOk()->assertSee($deliveryAddresses[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_customer_delivery_addresses()
    {
        $customer = Customer::factory()->create();
        $data = DeliveryAddress::factory()
            ->make([
                'customer_id' => $customer->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.customers.delivery-addresses.store', $customer),
            $data
        );

        unset($data['gps_location']);
        unset($data['customer_id']);

        $this->assertDatabaseHas('delivery_addresses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $deliveryAddress = DeliveryAddress::latest('id')->first();

        $this->assertEquals($customer->id, $deliveryAddress->customer_id);
    }
}
