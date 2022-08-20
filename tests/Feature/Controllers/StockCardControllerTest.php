<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\StockCard;

use App\Models\Store;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StockCardControllerTest extends TestCase
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
    public function it_displays_index_view_with_stock_cards()
    {
        $stockCards = StockCard::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('stock-cards.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.stock_cards.index')
            ->assertViewHas('stockCards');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_stock_card()
    {
        $response = $this->get(route('stock-cards.create'));

        $response->assertOk()->assertViewIs('app.stock_cards.create');
    }

    /**
     * @test
     */
    public function it_stores_the_stock_card()
    {
        $data = StockCard::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('stock-cards.store'), $data);

        $this->assertDatabaseHas('stock_cards', $data);

        $stockCard = StockCard::latest('id')->first();

        $response->assertRedirect(route('stock-cards.edit', $stockCard));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_stock_card()
    {
        $stockCard = StockCard::factory()->create();

        $response = $this->get(route('stock-cards.show', $stockCard));

        $response
            ->assertOk()
            ->assertViewIs('app.stock_cards.show')
            ->assertViewHas('stockCard');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_stock_card()
    {
        $stockCard = StockCard::factory()->create();

        $response = $this->get(route('stock-cards.edit', $stockCard));

        $response
            ->assertOk()
            ->assertViewIs('app.stock_cards.edit')
            ->assertViewHas('stockCard');
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

        $response = $this->put(route('stock-cards.update', $stockCard), $data);

        $data['id'] = $stockCard->id;

        $this->assertDatabaseHas('stock_cards', $data);

        $response->assertRedirect(route('stock-cards.edit', $stockCard));
    }

    /**
     * @test
     */
    public function it_deletes_the_stock_card()
    {
        $stockCard = StockCard::factory()->create();

        $response = $this->delete(route('stock-cards.destroy', $stockCard));

        $response->assertRedirect(route('stock-cards.index'));

        $this->assertModelMissing($stockCard);
    }
}
