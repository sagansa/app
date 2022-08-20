<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\Production;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreProductionsTest extends TestCase
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
    public function it_gets_store_productions()
    {
        $store = Store::factory()->create();
        $productions = Production::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(
            route('api.stores.productions.index', $store)
        );

        $response->assertOk()->assertSee($productions[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_store_productions()
    {
        $store = Store::factory()->create();
        $data = Production::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.productions.store', $store),
            $data
        );

        $this->assertDatabaseHas('productions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $production = Production::latest('id')->first();

        $this->assertEquals($store->id, $production->store_id);
    }
}
