<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Customer;
use App\Models\SalesOrderOnline;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerSalesOrderOnlinesTest extends TestCase
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
    public function it_gets_customer_sales_order_onlines()
    {
        $customer = Customer::factory()->create();
        $salesOrderOnlines = SalesOrderOnline::factory()
            ->count(2)
            ->create([
                'customer_id' => $customer->id,
            ]);

        $response = $this->getJson(
            route('api.customers.sales-order-onlines.index', $customer)
        );

        $response->assertOk()->assertSee($salesOrderOnlines[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_customer_sales_order_onlines()
    {
        $customer = Customer::factory()->create();
        $data = SalesOrderOnline::factory()
            ->make([
                'customer_id' => $customer->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.customers.sales-order-onlines.store', $customer),
            $data
        );

        $this->assertDatabaseHas('sales_order_onlines', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $salesOrderOnline = SalesOrderOnline::latest('id')->first();

        $this->assertEquals($customer->id, $salesOrderOnline->customer_id);
    }
}
