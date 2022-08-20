<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\StockCard;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserStockCardsTest extends TestCase
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
    public function it_gets_user_stock_cards()
    {
        $user = User::factory()->create();
        $stockCards = StockCard::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.stock-cards.index', $user));

        $response->assertOk()->assertSee($stockCards[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_user_stock_cards()
    {
        $user = User::factory()->create();
        $data = StockCard::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.stock-cards.store', $user),
            $data
        );

        $this->assertDatabaseHas('stock_cards', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $stockCard = StockCard::latest('id')->first();

        $this->assertEquals($user->id, $stockCard->user_id);
    }
}
