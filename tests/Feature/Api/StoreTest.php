<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreTest extends TestCase
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
    public function it_gets_stores_list()
    {
        $stores = Store::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.stores.index'));

        $response->assertOk()->assertSee($stores[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_store()
    {
        $data = Store::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.stores.store'), $data);

        unset($data['user_id']);

        $this->assertDatabaseHas('stores', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_store()
    {
        $store = Store::factory()->create();

        $user = User::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'nickname' => $this->faker->userName,
            'no_telp' => $this->faker->phoneNumber,
            'email' => $this->faker->unique->email,
            'status' => $this->faker->numberBetween(1, 4),
            'user_id' => $user->id,
        ];

        $response = $this->putJson(route('api.stores.update', $store), $data);

        unset($data['user_id']);

        $data['id'] = $store->id;

        $this->assertDatabaseHas('stores', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_store()
    {
        $store = Store::factory()->create();

        $response = $this->deleteJson(route('api.stores.destroy', $store));

        $this->assertModelMissing($store);

        $response->assertNoContent();
    }
}
