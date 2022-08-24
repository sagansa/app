<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\AccountCashless;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreAccountCashlessesTest extends TestCase
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
    public function it_gets_store_account_cashlesses()
    {
        $store = Store::factory()->create();
        $accountCashlesses = AccountCashless::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(
            route('api.stores.account-cashlesses.index', $store)
        );

        $response->assertOk()->assertSee($accountCashlesses[0]->email);
    }

    /**
     * @test
     */
    public function it_stores_the_store_account_cashlesses()
    {
        $store = Store::factory()->create();
        $data = AccountCashless::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.account-cashlesses.store', $store),
            $data
        );

        $this->assertDatabaseHas('account_cashlesses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $accountCashless = AccountCashless::latest('id')->first();

        $this->assertEquals($store->id, $accountCashless->store_id);
    }
}
