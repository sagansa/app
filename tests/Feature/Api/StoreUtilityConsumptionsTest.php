<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\UtilityConsumption;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreUtilityConsumptionsTest extends TestCase
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
    public function it_gets_store_utility_consumptions()
    {
        $store = Store::factory()->create();
        $utilityConsumptions = UtilityConsumption::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(
            route('api.stores.utility-consumptions.index', $store)
        );

        $response->assertOk()->assertSee($utilityConsumptions[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_store_utility_consumptions()
    {
        $store = Store::factory()->create();
        $data = UtilityConsumption::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.utility-consumptions.store', $store),
            $data
        );

        $this->assertDatabaseHas('utility_consumptions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $utilityConsumption = UtilityConsumption::latest('id')->first();

        $this->assertEquals($store->id, $utilityConsumption->store_id);
    }
}
