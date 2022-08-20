<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\Hygienic;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreHygienicsTest extends TestCase
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
    public function it_gets_store_hygienics()
    {
        $store = Store::factory()->create();
        $hygienics = Hygienic::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(route('api.stores.hygienics.index', $store));

        $response->assertOk()->assertSee($hygienics[0]->status);
    }

    /**
     * @test
     */
    public function it_stores_the_store_hygienics()
    {
        $store = Store::factory()->create();
        $data = Hygienic::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.hygienics.store', $store),
            $data
        );

        $this->assertDatabaseHas('hygienics', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $hygienic = Hygienic::latest('id')->first();

        $this->assertEquals($store->id, $hygienic->store_id);
    }
}
