<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ReceiptByItemLoyverse;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReceiptByItemLoyverseControllerTest extends TestCase
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
    public function it_displays_index_view_with_receipt_by_item_loyverses()
    {
        $receiptByItemLoyverses = ReceiptByItemLoyverse::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('receipt-by-item-loyverses.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.receipt_by_item_loyverses.index')
            ->assertViewHas('receiptByItemLoyverses');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_receipt_by_item_loyverse()
    {
        $response = $this->get(route('receipt-by-item-loyverses.create'));

        $response
            ->assertOk()
            ->assertViewIs('app.receipt_by_item_loyverses.create');
    }

    /**
     * @test
     */
    public function it_stores_the_receipt_by_item_loyverse()
    {
        $data = ReceiptByItemLoyverse::factory()
            ->make()
            ->toArray();

        $response = $this->post(
            route('receipt-by-item-loyverses.store'),
            $data
        );

        $this->assertDatabaseHas('receipt_by_item_loyverses', $data);

        $receiptByItemLoyverse = ReceiptByItemLoyverse::latest('id')->first();

        $response->assertRedirect(
            route('receipt-by-item-loyverses.edit', $receiptByItemLoyverse)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_receipt_by_item_loyverse()
    {
        $receiptByItemLoyverse = ReceiptByItemLoyverse::factory()->create();

        $response = $this->get(
            route('receipt-by-item-loyverses.show', $receiptByItemLoyverse)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.receipt_by_item_loyverses.show')
            ->assertViewHas('receiptByItemLoyverse');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_receipt_by_item_loyverse()
    {
        $receiptByItemLoyverse = ReceiptByItemLoyverse::factory()->create();

        $response = $this->get(
            route('receipt-by-item-loyverses.edit', $receiptByItemLoyverse)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.receipt_by_item_loyverses.edit')
            ->assertViewHas('receiptByItemLoyverse');
    }

    /**
     * @test
     */
    public function it_updates_the_receipt_by_item_loyverse()
    {
        $receiptByItemLoyverse = ReceiptByItemLoyverse::factory()->create();

        $data = [
            'date' => $this->faker->date,
            'receipt_number' => $this->faker->text(255),
            'receipt_type' => $this->faker->text(255),
            'category' => $this->faker->text(255),
            'sku' => $this->faker->text(255),
            'item' => $this->faker->text(255),
            'variant' => $this->faker->text(255),
            'modifiers_applied' => $this->faker->text(255),
            'quantity' => $this->faker->randomNumber,
            'gross_sales' => $this->faker->text(255),
            'discounts' => $this->faker->text(255),
            'net_sales' => $this->faker->text(255),
            'cost_of_goods' => $this->faker->text(255),
            'gross_profit' => $this->faker->text(255),
            'taxes' => $this->faker->text(255),
            'dining_option' => $this->faker->text(255),
            'pos' => $this->faker->text(255),
            'store' => $this->faker->text(255),
            'cashier_name' => $this->faker->text(255),
            'customer_name' => $this->faker->text(255),
            'customer_contacts' => $this->faker->text(255),
            'comment' => $this->faker->text(255),
            'status' => $this->faker->word,
        ];

        $response = $this->put(
            route('receipt-by-item-loyverses.update', $receiptByItemLoyverse),
            $data
        );

        $data['id'] = $receiptByItemLoyverse->id;

        $this->assertDatabaseHas('receipt_by_item_loyverses', $data);

        $response->assertRedirect(
            route('receipt-by-item-loyverses.edit', $receiptByItemLoyverse)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_receipt_by_item_loyverse()
    {
        $receiptByItemLoyverse = ReceiptByItemLoyverse::factory()->create();

        $response = $this->delete(
            route('receipt-by-item-loyverses.destroy', $receiptByItemLoyverse)
        );

        $response->assertRedirect(route('receipt-by-item-loyverses.index'));

        $this->assertModelMissing($receiptByItemLoyverse);
    }
}
