<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\UserCashless;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreUserCashlessesTest extends TestCase
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
    public function it_gets_store_user_cashlesses()
    {
        $store = Store::factory()->create();
        $userCashlesses = UserCashless::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(
            route('api.stores.user-cashlesses.index', $store)
        );

        $response->assertOk()->assertSee($userCashlesses[0]->email);
    }

    /**
     * @test
     */
    public function it_stores_the_store_user_cashlesses()
    {
        $store = Store::factory()->create();
        $data = UserCashless::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.user-cashlesses.store', $store),
            $data
        );

        $this->assertDatabaseHas('user_cashlesses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $userCashless = UserCashless::latest('id')->first();

        $this->assertEquals($store->id, $userCashless->store_id);
    }
}
