<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Cashless;
use App\Models\CashlessProvider;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CashlessProviderCashlessesTest extends TestCase
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
    public function it_gets_cashless_provider_cashlesses()
    {
        $cashlessProvider = CashlessProvider::factory()->create();
        $cashlesses = Cashless::factory()
            ->count(2)
            ->create([
                'cashless_provider_id' => $cashlessProvider->id,
            ]);

        $response = $this->getJson(
            route('api.cashless-providers.cashlesses.index', $cashlessProvider)
        );

        $response->assertOk()->assertSee($cashlesses[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_cashless_provider_cashlesses()
    {
        $cashlessProvider = CashlessProvider::factory()->create();
        $data = Cashless::factory()
            ->make([
                'cashless_provider_id' => $cashlessProvider->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.cashless-providers.cashlesses.store', $cashlessProvider),
            $data
        );

        unset($data['cashless_provider_id']);
        unset($data['image']);
        unset($data['bruto_apl']);
        unset($data['netto_apl']);
        unset($data['bruto_real']);
        unset($data['netto_real']);
        unset($data['image_canceled']);
        unset($data['canceled']);

        $this->assertDatabaseHas('cashlesses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $cashless = Cashless::latest('id')->first();

        $this->assertEquals(
            $cashlessProvider->id,
            $cashless->cashless_provider_id
        );
    }
}
