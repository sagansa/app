<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\UtilityUsage;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreUtilityUsagesTest extends TestCase
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
    public function it_gets_store_utility_usages()
    {
        $store = Store::factory()->create();
        $utilityUsages = UtilityUsage::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(
            route('api.stores.utility-usages.index', $store)
        );

        $response->assertOk()->assertSee($utilityUsages[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_store_utility_usages()
    {
        $store = Store::factory()->create();
        $data = UtilityUsage::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.utility-usages.store', $store),
            $data
        );

        $this->assertDatabaseHas('utility_usages', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $utilityUsage = UtilityUsage::latest('id')->first();

        $this->assertEquals($store->id, $utilityUsage->store_id);
    }
}
