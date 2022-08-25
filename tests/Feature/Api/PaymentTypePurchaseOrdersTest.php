<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\PaymentType;
use App\Models\PurchaseOrder;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentTypePurchaseOrdersTest extends TestCase
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
    public function it_gets_payment_type_purchase_orders()
    {
        $paymentType = PaymentType::factory()->create();
        $purchaseOrders = PurchaseOrder::factory()
            ->count(2)
            ->create([
                'payment_type_id' => $paymentType->id,
            ]);

        $response = $this->getJson(
            route('api.payment-types.purchase-orders.index', $paymentType)
        );

        $response->assertOk()->assertSee($purchaseOrders[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_payment_type_purchase_orders()
    {
        $paymentType = PaymentType::factory()->create();
        $data = PurchaseOrder::factory()
            ->make([
                'payment_type_id' => $paymentType->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.payment-types.purchase-orders.store', $paymentType),
            $data
        );

        $this->assertDatabaseHas('purchase_orders', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $purchaseOrder = PurchaseOrder::latest('id')->first();

        $this->assertEquals($paymentType->id, $purchaseOrder->payment_type_id);
    }
}
