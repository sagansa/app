<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ReceiptLoyverse;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReceiptLoyverseTest extends TestCase
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
    public function it_gets_receipt_loyverses_list()
    {
        $receiptLoyverses = ReceiptLoyverse::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.receipt-loyverses.index'));

        $response->assertOk()->assertSee($receiptLoyverses[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_receipt_loyverse()
    {
        $data = ReceiptLoyverse::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.receipt-loyverses.store'),
            $data
        );

        $this->assertDatabaseHas('receipt_loyverses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.receipt-loyverses.update', $receiptLoyverse),
            $data
        );

        $data['id'] = $receiptLoyverse->id;

        $this->assertDatabaseHas('receipt_loyverses', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_receipt_loyverse()
    {
        $receiptLoyverse = ReceiptLoyverse::factory()->create();

        $response = $this->deleteJson(
            route('api.receipt-loyverses.destroy', $receiptLoyverse)
        );

        $this->assertModelMissing($receiptLoyverse);

        $response->assertNoContent();
    }
}
