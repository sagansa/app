<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\AdminCashless;
use App\Models\CashlessProvider;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CashlessProviderAdminCashlessesTest extends TestCase
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
    public function it_gets_cashless_provider_admin_cashlesses()
    {
        $cashlessProvider = CashlessProvider::factory()->create();
        $adminCashlesses = AdminCashless::factory()
            ->count(2)
            ->create([
                'cashless_provider_id' => $cashlessProvider->id,
            ]);

        $response = $this->getJson(
            route(
                'api.cashless-providers.admin-cashlesses.index',
                $cashlessProvider
            )
        );

        $response->assertOk()->assertSee($adminCashlesses[0]->username);
    }

    /**
     * @test
     */
    public function it_stores_the_cashless_provider_admin_cashlesses()
    {
        $cashlessProvider = CashlessProvider::factory()->create();
        $data = AdminCashless::factory()
            ->make([
                'cashless_provider_id' => $cashlessProvider->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route(
                'api.cashless-providers.admin-cashlesses.store',
                $cashlessProvider
            ),
            $data
        );

        $this->assertDatabaseHas('admin_cashlesses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $adminCashless = AdminCashless::latest('id')->first();

        $this->assertEquals(
            $cashlessProvider->id,
            $adminCashless->cashless_provider_id
        );
    }
}
