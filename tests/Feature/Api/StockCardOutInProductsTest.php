<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\StockCard;
use App\Models\OutInProduct;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StockCardOutInProductsTest extends TestCase
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
    public function it_gets_stock_card_out_in_products()
    {
        $stockCard = StockCard::factory()->create();
        $outInProducts = OutInProduct::factory()
            ->count(2)
            ->create([
                'stock_card_id' => $stockCard->id,
            ]);

        $response = $this->getJson(
            route('api.stock-cards.out-in-products.index', $stockCard)
        );

        $response->assertOk()->assertSee($outInProducts[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_stock_card_out_in_products()
    {
        $stockCard = StockCard::factory()->create();
        $data = OutInProduct::factory()
            ->make([
                'stock_card_id' => $stockCard->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stock-cards.out-in-products.store', $stockCard),
            $data
        );

        unset($data['delivery_service_id']);

        $this->assertDatabaseHas('out_in_products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $outInProduct = OutInProduct::latest('id')->first();

        $this->assertEquals($stockCard->id, $outInProduct->stock_card_id);
    }
}
