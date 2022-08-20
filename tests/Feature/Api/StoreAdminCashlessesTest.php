<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\AdminCashless;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreAdminCashlessesTest extends TestCase
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
    public function it_gets_store_admin_cashlesses()
    {
        $store = Store::factory()->create();
        $adminCashlesses = AdminCashless::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(
            route('api.stores.admin-cashlesses.index', $store)
        );

        $response->assertOk()->assertSee($adminCashlesses[0]->username);
    }

    /**
     * @test
     */
    public function it_stores_the_store_admin_cashlesses()
    {
        $store = Store::factory()->create();
        $data = AdminCashless::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.admin-cashlesses.store', $store),
            $data
        );

        $this->assertDatabaseHas('admin_cashlesses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $adminCashless = AdminCashless::latest('id')->first();

        $this->assertEquals($store->id, $adminCashless->store_id);
    }
}
