<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\UserCashless;
use App\Models\AdminCashless;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserCashlessAdminCashlessesTest extends TestCase
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
    public function it_gets_user_cashless_admin_cashlesses()
    {
        $userCashless = UserCashless::factory()->create();
        $adminCashless = AdminCashless::factory()->create();

        $userCashless->adminCashlesses()->attach($adminCashless);

        $response = $this->getJson(
            route('api.user-cashlesses.admin-cashlesses.index', $userCashless)
        );

        $response->assertOk()->assertSee($adminCashless->username);
    }

    /**
     * @test
     */
    public function it_can_attach_admin_cashlesses_to_user_cashless()
    {
        $userCashless = UserCashless::factory()->create();
        $adminCashless = AdminCashless::factory()->create();

        $response = $this->postJson(
            route('api.user-cashlesses.admin-cashlesses.store', [
                $userCashless,
                $adminCashless,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $userCashless
                ->adminCashlesses()
                ->where('admin_cashlesses.id', $adminCashless->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_admin_cashlesses_from_user_cashless()
    {
        $userCashless = UserCashless::factory()->create();
        $adminCashless = AdminCashless::factory()->create();

        $response = $this->deleteJson(
            route('api.user-cashlesses.admin-cashlesses.store', [
                $userCashless,
                $adminCashless,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $userCashless
                ->adminCashlesses()
                ->where('admin_cashlesses.id', $adminCashless->id)
                ->exists()
        );
    }
}
