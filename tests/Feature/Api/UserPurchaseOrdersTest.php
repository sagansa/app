<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\PurchaseOrder;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserPurchaseOrdersTest extends TestCase
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
    public function it_gets_user_purchase_orders()
    {
        $user = User::factory()->create();
        $purchaseOrders = PurchaseOrder::factory()
            ->count(2)
            ->create([
                'approved_by_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.purchase-orders.index', $user)
        );

        $response->assertOk()->assertSee($purchaseOrders[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_user_purchase_orders()
    {
        $user = User::factory()->create();
        $data = PurchaseOrder::factory()
            ->make([
                'approved_by_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.purchase-orders.store', $user),
            $data
        );

        $this->assertDatabaseHas('purchase_orders', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $purchaseOrder = PurchaseOrder::latest('id')->first();

        $this->assertEquals($user->id, $purchaseOrder->approved_by_id);
    }
}
