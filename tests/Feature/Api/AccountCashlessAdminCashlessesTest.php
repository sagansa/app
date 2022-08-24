<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\AdminCashless;
use App\Models\AccountCashless;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountCashlessAdminCashlessesTest extends TestCase
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
    public function it_gets_account_cashless_admin_cashlesses()
    {
        $accountCashless = AccountCashless::factory()->create();
        $adminCashless = AdminCashless::factory()->create();

        $accountCashless->adminCashlesses()->attach($adminCashless);

        $response = $this->getJson(
            route(
                'api.account-cashlesses.admin-cashlesses.index',
                $accountCashless
            )
        );

        $response->assertOk()->assertSee($adminCashless->username);
    }

    /**
     * @test
     */
    public function it_can_attach_admin_cashlesses_to_account_cashless()
    {
        $accountCashless = AccountCashless::factory()->create();
        $adminCashless = AdminCashless::factory()->create();

        $response = $this->postJson(
            route('api.account-cashlesses.admin-cashlesses.store', [
                $accountCashless,
                $adminCashless,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $accountCashless
                ->adminCashlesses()
                ->where('admin_cashlesses.id', $adminCashless->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_admin_cashlesses_from_account_cashless()
    {
        $accountCashless = AccountCashless::factory()->create();
        $adminCashless = AdminCashless::factory()->create();

        $response = $this->deleteJson(
            route('api.account-cashlesses.admin-cashlesses.store', [
                $accountCashless,
                $adminCashless,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $accountCashless
                ->adminCashlesses()
                ->where('admin_cashlesses.id', $adminCashless->id)
                ->exists()
        );
    }
}
