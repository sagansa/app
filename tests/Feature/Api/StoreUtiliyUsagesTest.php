<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\UtiliyUsage;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreUtiliyUsagesTest extends TestCase
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
    public function it_gets_store_utiliy_usages()
    {
        $store = Store::factory()->create();
        $utiliyUsages = UtiliyUsage::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(
            route('api.stores.utiliy-usages.index', $store)
        );

        $response->assertOk()->assertSee($utiliyUsages[0]->notes);
    }

    /**
     * @test
     */
    public function it_stores_the_store_utiliy_usages()
    {
        $store = Store::factory()->create();
        $data = UtiliyUsage::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.utiliy-usages.store', $store),
            $data
        );

        $this->assertDatabaseHas('utiliy_usages', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $utiliyUsage = UtiliyUsage::latest('id')->first();

        $this->assertEquals($store->id, $utiliyUsage->store_id);
    }
}
