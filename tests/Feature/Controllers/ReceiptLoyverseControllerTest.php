<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ReceiptLoyverse;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReceiptLoyverseControllerTest extends TestCase
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
    public function it_displays_index_view_with_receipt_loyverses()
    {
        $receiptLoyverses = ReceiptLoyverse::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('receipt-loyverses.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.receipt_loyverses.index')
            ->assertViewHas('receiptLoyverses');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_receipt_loyverse()
    {
        $response = $this->get(route('receipt-loyverses.create'));

        $response->assertOk()->assertViewIs('app.receipt_loyverses.create');
    }

    /**
     * @test
     */
    public function it_stores_the_receipt_loyverse()
    {
        $data = ReceiptLoyverse::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('receipt-loyverses.store'), $data);

        $this->assertDatabaseHas('receipt_loyverses', $data);

        $receiptLoyverse = ReceiptLoyverse::latest('id')->first();

        $response->assertRedirect(
            route('receipt-loyverses.edit', $receiptLoyverse)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_receipt_loyverse()
    {
        $receiptLoyverse = ReceiptLoyverse::factory()->create();

        $response = $this->get(
            route('receipt-loyverses.show', $receiptLoyverse)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.receipt_loyverses.show')
            ->assertViewHas('receiptLoyverse');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_receipt_loyverse()
    {
        $receiptLoyverse = ReceiptLoyverse::factory()->create();

        $response = $this->get(
            route('receipt-loyverses.edit', $receiptLoyverse)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.receipt_loyverses.edit')
            ->assertViewHas('receiptLoyverse');
    }

    /**
     * @test
     */
    public function it_updates_the_receipt_loyverse()
    {
        $receiptLoyverse = ReceiptLoyverse::factory()->create();

        $data = [
            'date' => $this->faker->date,
            'receipt_number' => $this->faker->unique->text(255),
            'receipt_type' => $this->faker->text(255),
            'gross_sales' => $this->faker->text(255),
            'discounts' => $this->faker->text(255),
            'net_sales' => $this->faker->text(255),
            'taxes' => $this->faker->text(255),
            'total_collected' => $this->faker->text(255),
            'cost_of_goods' => $this->faker->text(255),
            'gross_profit' => $this->faker->text(255),
            'payment_type' => $this->faker->text(255),
            'description' => $this->faker->text,
            'dining_option' => $this->faker->text(255),
            'pos' => $this->faker->text(255),
            'store' => $this->faker->text(255),
            'cashier_name' => $this->faker->text(255),
            'customer_name' => $this->faker->text(255),
            'customer_contacts' => $this->faker->text(255),
            'status' => $this->faker->word,
        ];

        $response = $this->put(
            route('receipt-loyverses.update', $receiptLoyverse),
            $data
        );

        $data['id'] = $receiptLoyverse->id;

        $this->assertDatabaseHas('receipt_loyverses', $data);

        $response->assertRedirect(
            route('receipt-loyverses.edit', $receiptLoyverse)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_receipt_loyverse()
    {
        $receiptLoyverse = ReceiptLoyverse::factory()->create();

        $response = $this->delete(
            route('receipt-loyverses.destroy', $receiptLoyverse)
        );

        $response->assertRedirect(route('receipt-loyverses.index'));

        $this->assertModelMissing($receiptLoyverse);
    }
}
