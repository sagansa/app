<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\UserCashless;
use App\Models\CashlessProvider;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CashlessProviderUserCashlessesTest extends TestCase
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
    public function it_gets_cashless_provider_user_cashlesses()
    {
        $cashlessProvider = CashlessProvider::factory()->create();
        $userCashlesses = UserCashless::factory()
            ->count(2)
            ->create([
                'cashless_provider_id' => $cashlessProvider->id,
            ]);

        $response = $this->getJson(
            route(
                'api.cashless-providers.user-cashlesses.index',
                $cashlessProvider
            )
        );

        $response->assertOk()->assertSee($userCashlesses[0]->email);
    }

    /**
     * @test
     */
    public function it_stores_the_cashless_provider_user_cashlesses()
    {
        $cashlessProvider = CashlessProvider::factory()->create();
        $data = UserCashless::factory()
            ->make([
                'cashless_provider_id' => $cashlessProvider->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route(
                'api.cashless-providers.user-cashlesses.store',
                $cashlessProvider
            ),
            $data
        );

        $this->assertDatabaseHas('user_cashlesses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $userCashless = UserCashless::latest('id')->first();

        $this->assertEquals(
            $cashlessProvider->id,
            $userCashless->cashless_provider_id
        );
    }
}
