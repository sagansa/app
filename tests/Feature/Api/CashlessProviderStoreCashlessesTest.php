<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\StoreCashless;
use App\Models\CashlessProvider;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CashlessProviderStoreCashlessesTest extends TestCase
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
    public function it_gets_cashless_provider_store_cashlesses()
    {
        $cashlessProvider = CashlessProvider::factory()->create();
        $storeCashlesses = StoreCashless::factory()
            ->count(2)
            ->create([
                'cashless_provider_id' => $cashlessProvider->id,
            ]);

        $response = $this->getJson(
            route(
                'api.cashless-providers.store-cashlesses.index',
                $cashlessProvider
            )
        );

        $response->assertOk()->assertSee($storeCashlesses[0]->email);
    }

    /**
     * @test
     */
    public function it_stores_the_cashless_provider_store_cashlesses()
    {
        $cashlessProvider = CashlessProvider::factory()->create();
        $data = StoreCashless::factory()
            ->make([
                'cashless_provider_id' => $cashlessProvider->id,
            ])
            ->toArray();
        $data['password'] = \Str::random('8');

        $response = $this->postJson(
            route(
                'api.cashless-providers.store-cashlesses.store',
                $cashlessProvider
            ),
            $data
        );

        unset($data['password']);

        $this->assertDatabaseHas('store_cashlesses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $storeCashless = StoreCashless::latest('id')->first();

        $this->assertEquals(
            $cashlessProvider->id,
            $storeCashless->cashless_provider_id
        );
    }
}
