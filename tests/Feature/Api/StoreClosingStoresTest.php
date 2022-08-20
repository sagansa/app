<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\ClosingStore;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreClosingStoresTest extends TestCase
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
    public function it_gets_store_closing_stores()
    {
        $store = Store::factory()->create();
        $closingStores = ClosingStore::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(
            route('api.stores.closing-stores.index', $store)
        );

        $response->assertOk()->assertSee($closingStores[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_store_closing_stores()
    {
        $store = Store::factory()->create();
        $data = ClosingStore::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.closing-stores.store', $store),
            $data
        );

        $this->assertDatabaseHas('closing_stores', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $closingStore = ClosingStore::latest('id')->first();

        $this->assertEquals($store->id, $closingStore->store_id);
    }
}
