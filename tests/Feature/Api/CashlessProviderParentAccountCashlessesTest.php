<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\CashlessProvider;
use App\Models\ParentAccountCashless;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CashlessProviderParentAccountCashlessesTest extends TestCase
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
    public function it_gets_cashless_provider_parent_account_cashlesses()
    {
        $cashlessProvider = CashlessProvider::factory()->create();
        $parentAccountCashlesses = ParentAccountCashless::factory()
            ->count(2)
            ->create([
                'cashless_provider_id' => $cashlessProvider->id,
            ]);

        $response = $this->getJson(
            route(
                'api.cashless-providers.parent-account-cashlesses.index',
                $cashlessProvider
            )
        );

        $response->assertOk()->assertSee($parentAccountCashlesses[0]->username);
    }

    /**
     * @test
     */
    public function it_stores_the_cashless_provider_parent_account_cashlesses()
    {
        $cashlessProvider = CashlessProvider::factory()->create();
        $data = ParentAccountCashless::factory()
            ->make([
                'cashless_provider_id' => $cashlessProvider->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route(
                'api.cashless-providers.parent-account-cashlesses.store',
                $cashlessProvider
            ),
            $data
        );

        $this->assertDatabaseHas('parent_account_cashlesses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $parentAccountCashless = ParentAccountCashless::latest('id')->first();

        $this->assertEquals(
            $cashlessProvider->id,
            $parentAccountCashless->cashless_provider_id
        );
    }
}
