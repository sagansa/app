<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\StoreCashless;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreStoreCashlessesTest extends TestCase
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
    public function it_gets_store_store_cashlesses()
    {
        $store = Store::factory()->create();
        $storeCashlesses = StoreCashless::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(
            route('api.stores.store-cashlesses.index', $store)
        );

        $response->assertOk()->assertSee($storeCashlesses[0]->email);
    }

    /**
     * @test
     */
    public function it_stores_the_store_store_cashlesses()
    {
        $store = Store::factory()->create();
        $data = StoreCashless::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();
        $data['password'] = \Str::random('8');

        $response = $this->postJson(
            route('api.stores.store-cashlesses.store', $store),
            $data
        );

        unset($data['password']);

        $this->assertDatabaseHas('store_cashlesses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $storeCashless = StoreCashless::latest('id')->first();

        $this->assertEquals($store->id, $storeCashless->store_id);
    }
}
