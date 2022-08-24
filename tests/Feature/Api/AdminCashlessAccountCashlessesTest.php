<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\AdminCashless;
use App\Models\AccountCashless;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminCashlessAccountCashlessesTest extends TestCase
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
    public function it_gets_admin_cashless_account_cashlesses()
    {
        $adminCashless = AdminCashless::factory()->create();
        $accountCashless = AccountCashless::factory()->create();

        $adminCashless->accountCashlesses()->attach($accountCashless);

        $response = $this->getJson(
            route(
                'api.admin-cashlesses.account-cashlesses.index',
                $adminCashless
            )
        );

        $response->assertOk()->assertSee($accountCashless->email);
    }

    /**
     * @test
     */
    public function it_can_attach_account_cashlesses_to_admin_cashless()
    {
        $adminCashless = AdminCashless::factory()->create();
        $accountCashless = AccountCashless::factory()->create();

        $response = $this->postJson(
            route('api.admin-cashlesses.account-cashlesses.store', [
                $adminCashless,
                $accountCashless,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $adminCashless
                ->accountCashlesses()
                ->where('account_cashlesses.id', $accountCashless->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_account_cashlesses_from_admin_cashless()
    {
        $adminCashless = AdminCashless::factory()->create();
        $accountCashless = AccountCashless::factory()->create();

        $response = $this->deleteJson(
            route('api.admin-cashlesses.account-cashlesses.store', [
                $adminCashless,
                $accountCashless,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $adminCashless
                ->accountCashlesses()
                ->where('account_cashlesses.id', $accountCashless->id)
                ->exists()
        );
    }
}
