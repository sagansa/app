<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\SalesOrderEmployee;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductSalesOrderEmployeesTest extends TestCase
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
    public function it_gets_product_sales_order_employees()
    {
        $product = Product::factory()->create();
        $salesOrderEmployee = SalesOrderEmployee::factory()->create();

        $product->salesOrderEmployees()->attach($salesOrderEmployee);

        $response = $this->getJson(
            route('api.products.sales-order-employees.index', $product)
        );

        $response->assertOk()->assertSee($salesOrderEmployee->date);
    }

    /**
     * @test
     */
    public function it_can_attach_sales_order_employees_to_product()
    {
        $product = Product::factory()->create();
        $salesOrderEmployee = SalesOrderEmployee::factory()->create();

        $response = $this->postJson(
            route('api.products.sales-order-employees.store', [
                $product,
                $salesOrderEmployee,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $product
                ->salesOrderEmployees()
                ->where('sales_order_employees.id', $salesOrderEmployee->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_sales_order_employees_from_product()
    {
        $product = Product::factory()->create();
        $salesOrderEmployee = SalesOrderEmployee::factory()->create();

        $response = $this->deleteJson(
            route('api.products.sales-order-employees.store', [
                $product,
                $salesOrderEmployee,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $product
                ->salesOrderEmployees()
                ->where('sales_order_employees.id', $salesOrderEmployee->id)
                ->exists()
        );
    }
}
