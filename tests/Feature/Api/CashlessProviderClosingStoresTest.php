<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ClosingStore;
use App\Models\CashlessProvider;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CashlessProviderClosingStoresTest extends TestCase
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
    public function it_gets_cashless_provider_closing_stores()
    {
        $cashlessProvider = CashlessProvider::factory()->create();
        $closingStore = ClosingStore::factory()->create();

        $cashlessProvider->closingStores()->attach($closingStore);

        $response = $this->getJson(
            route(
                'api.cashless-providers.closing-stores.index',
                $cashlessProvider
            )
        );

        $response->assertOk()->assertSee($closingStore->date);
    }

    /**
     * @test
     */
    public function it_can_attach_closing_stores_to_cashless_provider()
    {
        $cashlessProvider = CashlessProvider::factory()->create();
        $closingStore = ClosingStore::factory()->create();

        $response = $this->postJson(
            route('api.cashless-providers.closing-stores.store', [
                $cashlessProvider,
                $closingStore,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $cashlessProvider
                ->closingStores()
                ->where('closing_stores.id', $closingStore->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_closing_stores_from_cashless_provider()
    {
        $cashlessProvider = CashlessProvider::factory()->create();
        $closingStore = ClosingStore::factory()->create();

        $response = $this->deleteJson(
            route('api.cashless-providers.closing-stores.store', [
                $cashlessProvider,
                $closingStore,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $cashlessProvider
                ->closingStores()
                ->where('closing_stores.id', $closingStore->id)
                ->exists()
        );
    }
}
