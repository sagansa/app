<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\PurchaseReceipt;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchaseReceiptTest extends TestCase
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
    public function it_gets_purchase_receipts_list()
    {
        $purchaseReceipts = PurchaseReceipt::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.purchase-receipts.index'));

        $response->assertOk()->assertSee($purchaseReceipts[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_purchase_receipt()
    {
        $data = PurchaseReceipt::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.purchase-receipts.store'),
            $data
        );

        unset($data['user_id']);

        $this->assertDatabaseHas('purchase_receipts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_purchase_receipt()
    {
        $purchaseReceipt = PurchaseReceipt::factory()->create();

        $user = User::factory()->create();

        $data = [
            'nominal_transfer' => $this->faker->randomNumber,
            'user_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.purchase-receipts.update', $purchaseReceipt),
            $data
        );

        unset($data['user_id']);

        $data['id'] = $purchaseReceipt->id;

        $this->assertDatabaseHas('purchase_receipts', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_purchase_receipt()
    {
        $purchaseReceipt = PurchaseReceipt::factory()->create();

        $response = $this->deleteJson(
            route('api.purchase-receipts.destroy', $purchaseReceipt)
        );

        $this->assertModelMissing($purchaseReceipt);

        $response->assertNoContent();
    }
}
