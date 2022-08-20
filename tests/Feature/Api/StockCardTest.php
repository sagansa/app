<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\StockCard;

use App\Models\Store;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StockCardTest extends TestCase
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
    public function it_gets_stock_cards_list()
    {
        $stockCards = StockCard::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.stock-cards.index'));

        $response->assertOk()->assertSee($stockCards[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_stock_card()
    {
        $data = StockCard::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.stock-cards.store'), $data);

        $this->assertDatabaseHas('stock_cards', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_stock_card()
    {
        $stockCard = StockCard::factory()->create();

        $store = Store::factory()->create();
        $user = User::factory()->create();

        $data = [
            'date' => $this->faker->date,
            'store_id' => $store->id,
            'user_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.stock-cards.update', $stockCard),
            $data
        );

        $data['id'] = $stockCard->id;

        $this->assertDatabaseHas('stock_cards', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_stock_card()
    {
        $stockCard = StockCard::factory()->create();

        $response = $this->deleteJson(
            route('api.stock-cards.destroy', $stockCard)
        );

        $this->assertModelMissing($stockCard);

        $response->assertNoContent();
    }
}
