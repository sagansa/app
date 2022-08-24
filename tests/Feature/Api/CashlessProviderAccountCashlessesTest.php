<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\AccountCashless;
use App\Models\CashlessProvider;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CashlessProviderAccountCashlessesTest extends TestCase
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
    public function it_gets_cashless_provider_account_cashlesses()
    {
        $cashlessProvider = CashlessProvider::factory()->create();
        $accountCashlesses = AccountCashless::factory()
            ->count(2)
            ->create([
                'cashless_provider_id' => $cashlessProvider->id,
            ]);

        $response = $this->getJson(
            route(
                'api.cashless-providers.account-cashlesses.index',
                $cashlessProvider
            )
        );

        $response->assertOk()->assertSee($accountCashlesses[0]->email);
    }

    /**
     * @test
     */
    public function it_stores_the_cashless_provider_account_cashlesses()
    {
        $cashlessProvider = CashlessProvider::factory()->create();
        $data = AccountCashless::factory()
            ->make([
                'cashless_provider_id' => $cashlessProvider->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route(
                'api.cashless-providers.account-cashlesses.store',
                $cashlessProvider
            ),
            $data
        );

        $this->assertDatabaseHas('account_cashlesses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $accountCashless = AccountCashless::latest('id')->first();

        $this->assertEquals(
            $cashlessProvider->id,
            $accountCashless->cashless_provider_id
        );
    }
}
