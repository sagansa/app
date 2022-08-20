<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Unit;
use App\Models\PurchaseOrderProduct;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnitPurchaseOrderProductsTest extends TestCase
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
    public function it_gets_unit_purchase_order_products()
    {
        $unit = Unit::factory()->create();
        $purchaseOrderProducts = PurchaseOrderProduct::factory()
            ->count(2)
            ->create([
                'unit_id' => $unit->id,
            ]);

        $response = $this->getJson(
            route('api.units.purchase-order-products.index', $unit)
        );

        $response
            ->assertOk()
            ->assertSee($purchaseOrderProducts[0]->quantity_invoice);
    }

    /**
     * @test
     */
    public function it_stores_the_unit_purchase_order_products()
    {
        $unit = Unit::factory()->create();
        $data = PurchaseOrderProduct::factory()
            ->make([
                'unit_id' => $unit->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.units.purchase-order-products.store', $unit),
            $data
        );

        unset($data['purchase_order_id']);

        $this->assertDatabaseHas('purchase_order_products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $purchaseOrderProduct = PurchaseOrderProduct::latest('id')->first();

        $this->assertEquals($unit->id, $purchaseOrderProduct->unit_id);
    }
}
