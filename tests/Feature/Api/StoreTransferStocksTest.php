<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\TransferStock;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreTransferStocksTest extends TestCase
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
    public function it_gets_store_transfer_stocks()
    {
        $store = Store::factory()->create();
        $transferStocks = TransferStock::factory()
            ->count(2)
            ->create([
                'to_store_id' => $store->id,
            ]);

        $response = $this->getJson(
            route('api.stores.transfer-stocks.index', $store)
        );

        $response->assertOk()->assertSee($transferStocks[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_store_transfer_stocks()
    {
        $store = Store::factory()->create();
        $data = TransferStock::factory()
            ->make([
                'to_store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.transfer-stocks.store', $store),
            $data
        );

        unset($data['image']);

        $this->assertDatabaseHas('transfer_stocks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $transferStock = TransferStock::latest('id')->first();

        $this->assertEquals($store->id, $transferStock->to_store_id);
    }
}
