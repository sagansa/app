<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\RemainingStock;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreRemainingStocksTest extends TestCase
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
    public function it_gets_store_remaining_stocks()
    {
        $store = Store::factory()->create();
        $remainingStocks = RemainingStock::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(
            route('api.stores.remaining-stocks.index', $store)
        );

        $response->assertOk()->assertSee($remainingStocks[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_store_remaining_stocks()
    {
        $store = Store::factory()->create();
        $data = RemainingStock::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.remaining-stocks.store', $store),
            $data
        );

        $this->assertDatabaseHas('remaining_stocks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $remainingStock = RemainingStock::latest('id')->first();

        $this->assertEquals($store->id, $remainingStock->store_id);
    }
}
