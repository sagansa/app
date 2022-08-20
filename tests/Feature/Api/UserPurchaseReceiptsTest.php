<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\PurchaseReceipt;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserPurchaseReceiptsTest extends TestCase
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
    public function it_gets_user_purchase_receipts()
    {
        $user = User::factory()->create();
        $purchaseReceipts = PurchaseReceipt::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.purchase-receipts.index', $user)
        );

        $response->assertOk()->assertSee($purchaseReceipts[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_user_purchase_receipts()
    {
        $user = User::factory()->create();
        $data = PurchaseReceipt::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.purchase-receipts.store', $user),
            $data
        );

        unset($data['user_id']);

        $this->assertDatabaseHas('purchase_receipts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $purchaseReceipt = PurchaseReceipt::latest('id')->first();

        $this->assertEquals($user->id, $purchaseReceipt->user_id);
    }
}
