<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\SelfConsumption;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreSelfConsumptionsTest extends TestCase
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
    public function it_gets_store_self_consumptions()
    {
        $store = Store::factory()->create();
        $selfConsumptions = SelfConsumption::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(
            route('api.stores.self-consumptions.index', $store)
        );

        $response->assertOk()->assertSee($selfConsumptions[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_store_self_consumptions()
    {
        $store = Store::factory()->create();
        $data = SelfConsumption::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.self-consumptions.store', $store),
            $data
        );

        $this->assertDatabaseHas('self_consumptions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $selfConsumption = SelfConsumption::latest('id')->first();

        $this->assertEquals($store->id, $selfConsumption->store_id);
    }
}
