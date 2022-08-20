<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ClosingStore;
use App\Models\ClosingCourier;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClosingCourierClosingStoresTest extends TestCase
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
    public function it_gets_closing_courier_closing_stores()
    {
        $closingCourier = ClosingCourier::factory()->create();
        $closingStore = ClosingStore::factory()->create();

        $closingCourier->closingStores()->attach($closingStore);

        $response = $this->getJson(
            route('api.closing-couriers.closing-stores.index', $closingCourier)
        );

        $response->assertOk()->assertSee($closingStore->date);
    }

    /**
     * @test
     */
    public function it_can_attach_closing_stores_to_closing_courier()
    {
        $closingCourier = ClosingCourier::factory()->create();
        $closingStore = ClosingStore::factory()->create();

        $response = $this->postJson(
            route('api.closing-couriers.closing-stores.store', [
                $closingCourier,
                $closingStore,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $closingCourier
                ->closingStores()
                ->where('closing_stores.id', $closingStore->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_closing_stores_from_closing_courier()
    {
        $closingCourier = ClosingCourier::factory()->create();
        $closingStore = ClosingStore::factory()->create();

        $response = $this->deleteJson(
            route('api.closing-couriers.closing-stores.store', [
                $closingCourier,
                $closingStore,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $closingCourier
                ->closingStores()
                ->where('closing_stores.id', $closingStore->id)
                ->exists()
        );
    }
}
