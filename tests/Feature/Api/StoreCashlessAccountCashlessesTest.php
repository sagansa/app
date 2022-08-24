<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\StoreCashless;
use App\Models\AccountCashless;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreCashlessAccountCashlessesTest extends TestCase
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
    public function it_gets_store_cashless_account_cashlesses()
    {
        $storeCashless = StoreCashless::factory()->create();
        $accountCashlesses = AccountCashless::factory()
            ->count(2)
            ->create([
                'store_cashless_id' => $storeCashless->id,
            ]);

        $response = $this->getJson(
            route(
                'api.store-cashlesses.account-cashlesses.index',
                $storeCashless
            )
        );

        $response->assertOk()->assertSee($accountCashlesses[0]->email);
    }

    /**
     * @test
     */
    public function it_stores_the_store_cashless_account_cashlesses()
    {
        $storeCashless = StoreCashless::factory()->create();
        $data = AccountCashless::factory()
            ->make([
                'store_cashless_id' => $storeCashless->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route(
                'api.store-cashlesses.account-cashlesses.store',
                $storeCashless
            ),
            $data
        );

        $this->assertDatabaseHas('account_cashlesses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $accountCashless = AccountCashless::latest('id')->first();

        $this->assertEquals(
            $storeCashless->id,
            $accountCashless->store_cashless_id
        );
    }
}
