<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserStoresTest extends TestCase
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
    public function it_gets_user_stores()
    {
        $user = User::factory()->create();
        $stores = Store::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.stores.index', $user));

        $response->assertOk()->assertSee($stores[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_user_stores()
    {
        $user = User::factory()->create();
        $data = Store::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.stores.store', $user),
            $data
        );

        unset($data['user_id']);

        $this->assertDatabaseHas('stores', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $store = Store::latest('id')->first();

        $this->assertEquals($user->id, $store->user_id);
    }
}
