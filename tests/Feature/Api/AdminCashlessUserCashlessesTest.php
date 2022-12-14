<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\UserCashless;
use App\Models\AdminCashless;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminCashlessUserCashlessesTest extends TestCase
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
    public function it_gets_admin_cashless_user_cashlesses()
    {
        $adminCashless = AdminCashless::factory()->create();
        $userCashless = UserCashless::factory()->create();

        $adminCashless->userCashlesses()->attach($userCashless);

        $response = $this->getJson(
            route('api.admin-cashlesses.user-cashlesses.index', $adminCashless)
        );

        $response->assertOk()->assertSee($userCashless->email);
    }

    /**
     * @test
     */
    public function it_can_attach_user_cashlesses_to_admin_cashless()
    {
        $adminCashless = AdminCashless::factory()->create();
        $userCashless = UserCashless::factory()->create();

        $response = $this->postJson(
            route('api.admin-cashlesses.user-cashlesses.store', [
                $adminCashless,
                $userCashless,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $adminCashless
                ->userCashlesses()
                ->where('user_cashlesses.id', $userCashless->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_user_cashlesses_from_admin_cashless()
    {
        $adminCashless = AdminCashless::factory()->create();
        $userCashless = UserCashless::factory()->create();

        $response = $this->deleteJson(
            route('api.admin-cashlesses.user-cashlesses.store', [
                $adminCashless,
                $userCashless,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $adminCashless
                ->userCashlesses()
                ->where('user_cashlesses.id', $userCashless->id)
                ->exists()
        );
    }
}
