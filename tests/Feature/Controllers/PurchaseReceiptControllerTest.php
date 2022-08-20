<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\PurchaseReceipt;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchaseReceiptControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_purchase_receipts()
    {
        $purchaseReceipts = PurchaseReceipt::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('purchase-receipts.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.purchase_receipts.index')
            ->assertViewHas('purchaseReceipts');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_purchase_receipt()
    {
        $response = $this->get(route('purchase-receipts.create'));

        $response->assertOk()->assertViewIs('app.purchase_receipts.create');
    }

    /**
     * @test
     */
    public function it_stores_the_purchase_receipt()
    {
        $data = PurchaseReceipt::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('purchase-receipts.store'), $data);

        unset($data['user_id']);

        $this->assertDatabaseHas('purchase_receipts', $data);

        $purchaseReceipt = PurchaseReceipt::latest('id')->first();

        $response->assertRedirect(
            route('purchase-receipts.edit', $purchaseReceipt)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_purchase_receipt()
    {
        $purchaseReceipt = PurchaseReceipt::factory()->create();

        $response = $this->get(
            route('purchase-receipts.show', $purchaseReceipt)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.purchase_receipts.show')
            ->assertViewHas('purchaseReceipt');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_purchase_receipt()
    {
        $purchaseReceipt = PurchaseReceipt::factory()->create();

        $response = $this->get(
            route('purchase-receipts.edit', $purchaseReceipt)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.purchase_receipts.edit')
            ->assertViewHas('purchaseReceipt');
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

        $response = $this->put(
            route('purchase-receipts.update', $purchaseReceipt),
            $data
        );

        unset($data['user_id']);

        $data['id'] = $purchaseReceipt->id;

        $this->assertDatabaseHas('purchase_receipts', $data);

        $response->assertRedirect(
            route('purchase-receipts.edit', $purchaseReceipt)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_purchase_receipt()
    {
        $purchaseReceipt = PurchaseReceipt::factory()->create();

        $response = $this->delete(
            route('purchase-receipts.destroy', $purchaseReceipt)
        );

        $response->assertRedirect(route('purchase-receipts.index'));

        $this->assertModelMissing($purchaseReceipt);
    }
}
