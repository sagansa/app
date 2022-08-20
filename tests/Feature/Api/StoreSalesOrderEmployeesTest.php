<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\SalesOrderEmployee;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreSalesOrderEmployeesTest extends TestCase
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
    public function it_gets_store_sales_order_employees()
    {
        $store = Store::factory()->create();
        $salesOrderEmployees = SalesOrderEmployee::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(
            route('api.stores.sales-order-employees.index', $store)
        );

        $response->assertOk()->assertSee($salesOrderEmployees[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_store_sales_order_employees()
    {
        $store = Store::factory()->create();
        $data = SalesOrderEmployee::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.sales-order-employees.store', $store),
            $data
        );

        $this->assertDatabaseHas('sales_order_employees', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $salesOrderEmployee = SalesOrderEmployee::latest('id')->first();

        $this->assertEquals($store->id, $salesOrderEmployee->store_id);
    }
}
