<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\Utility;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreUtilitiesTest extends TestCase
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
    public function it_gets_store_utilities()
    {
        $store = Store::factory()->create();
        $utilities = Utility::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(route('api.stores.utilities.index', $store));

        $response->assertOk()->assertSee($utilities[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_store_utilities()
    {
        $store = Store::factory()->create();
        $data = Utility::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.utilities.store', $store),
            $data
        );

        $this->assertDatabaseHas('utilities', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $utility = Utility::latest('id')->first();

        $this->assertEquals($store->id, $utility->store_id);
    }
}
