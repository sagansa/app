<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\Consumption;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreConsumptionsTest extends TestCase
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
    public function it_gets_store_consumptions()
    {
        $store = Store::factory()->create();
        $consumptions = Consumption::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(
            route('api.stores.consumptions.index', $store)
        );

        $response->assertOk()->assertSee($consumptions[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_store_consumptions()
    {
        $store = Store::factory()->create();
        $data = Consumption::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.consumptions.store', $store),
            $data
        );

        $this->assertDatabaseHas('consumptions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $consumption = Consumption::latest('id')->first();

        $this->assertEquals($store->id, $consumption->store_id);
    }
}
