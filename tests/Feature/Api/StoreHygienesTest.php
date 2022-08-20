<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\Hygiene;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreHygienesTest extends TestCase
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
    public function it_gets_store_hygienes()
    {
        $store = Store::factory()->create();
        $hygienes = Hygiene::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(route('api.stores.hygienes.index', $store));

        $response->assertOk()->assertSee($hygienes[0]->notes);
    }

    /**
     * @test
     */
    public function it_stores_the_store_hygienes()
    {
        $store = Store::factory()->create();
        $data = Hygiene::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.hygienes.store', $store),
            $data
        );

        $this->assertDatabaseHas('hygienes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $hygiene = Hygiene::latest('id')->first();

        $this->assertEquals($store->id, $hygiene->store_id);
    }
}
