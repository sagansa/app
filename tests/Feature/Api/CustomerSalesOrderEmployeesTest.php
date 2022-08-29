<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Customer;
use App\Models\SalesOrderEmployee;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerSalesOrderEmployeesTest extends TestCase
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
    public function it_gets_customer_sales_order_employees()
    {
        $customer = Customer::factory()->create();
        $salesOrderEmployees = SalesOrderEmployee::factory()
            ->count(2)
            ->create([
                'customer_id' => $customer->id,
            ]);

        $response = $this->getJson(
            route('api.customers.sales-order-employees.index', $customer)
        );

        $response->assertOk()->assertSee($salesOrderEmployees[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_customer_sales_order_employees()
    {
        $customer = Customer::factory()->create();
        $data = SalesOrderEmployee::factory()
            ->make([
                'customer_id' => $customer->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.customers.sales-order-employees.store', $customer),
            $data
        );

        $this->assertDatabaseHas('sales_order_employees', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $salesOrderEmployee = SalesOrderEmployee::latest('id')->first();

        $this->assertEquals($customer->id, $salesOrderEmployee->customer_id);
    }
}
