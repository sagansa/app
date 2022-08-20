<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ReceiptByItemLoyverse;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReceiptByItemLoyverseTest extends TestCase
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
    public function it_gets_receipt_by_item_loyverses_list()
    {
        $receiptByItemLoyverses = ReceiptByItemLoyverse::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(
            route('api.receipt-by-item-loyverses.index')
        );

        $response->assertOk()->assertSee($receiptByItemLoyverses[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_receipt_by_item_loyverse()
    {
        $data = ReceiptByItemLoyverse::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.receipt-by-item-loyverses.store'),
            $data
        );

        $this->assertDatabaseHas('receipt_by_item_loyverses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route(
                'api.receipt-by-item-loyverses.update',
                $receiptByItemLoyverse
            ),
            $data
        );

        $data['id'] = $receiptByItemLoyverse->id;

        $this->assertDatabaseHas('receipt_by_item_loyverses', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_receipt_by_item_loyverse()
    {
        $receiptByItemLoyverse = ReceiptByItemLoyverse::factory()->create();

        $response = $this->deleteJson(
            route(
                'api.receipt-by-item-loyverses.destroy',
                $receiptByItemLoyverse
            )
        );

        $this->assertModelMissing($receiptByItemLoyverse);

        $response->assertNoContent();
    }
}
