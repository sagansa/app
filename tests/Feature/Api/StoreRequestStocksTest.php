<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\RequestStock;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreRequestStocksTest extends TestCase
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
    public function it_gets_store_request_stocks()
    {
        $store = Store::factory()->create();
        $requestStocks = RequestStock::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(
            route('api.stores.request-stocks.index', $store)
        );

        $response->assertOk()->assertSee($requestStocks[0]->notes);
    }

    /**
     * @test
     */
    public function it_stores_the_store_request_stocks()
    {
        $store = Store::factory()->create();
        $data = RequestStock::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.request-stocks.store', $store),
            $data
        );

        $this->assertDatabaseHas('request_stocks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $requestStock = RequestStock::latest('id')->first();

        $this->assertEquals($store->id, $requestStock->store_id);
    }
}
