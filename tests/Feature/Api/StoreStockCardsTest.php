<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\StockCard;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreStockCardsTest extends TestCase
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
    public function it_gets_store_stock_cards()
    {
        $store = Store::factory()->create();
        $stockCards = StockCard::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(
            route('api.stores.stock-cards.index', $store)
        );

        $response->assertOk()->assertSee($stockCards[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_store_stock_cards()
    {
        $store = Store::factory()->create();
        $data = StockCard::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.stock-cards.store', $store),
            $data
        );

        $this->assertDatabaseHas('stock_cards', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $stockCard = StockCard::latest('id')->first();

        $this->assertEquals($store->id, $stockCard->store_id);
    }
}
