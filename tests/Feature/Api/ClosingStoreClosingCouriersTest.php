<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ClosingStore;
use App\Models\ClosingCourier;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClosingStoreClosingCouriersTest extends TestCase
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
    public function it_gets_closing_store_closing_couriers()
    {
        $closingStore = ClosingStore::factory()->create();
        $closingCourier = ClosingCourier::factory()->create();

        $closingStore->closingCouriers()->attach($closingCourier);

        $response = $this->getJson(
            route('api.closing-stores.closing-couriers.index', $closingStore)
        );

        $response->assertOk()->assertSee($closingCourier->image);
    }

    /**
     * @test
     */
    public function it_can_attach_closing_couriers_to_closing_store()
    {
        $closingStore = ClosingStore::factory()->create();
        $closingCourier = ClosingCourier::factory()->create();

        $response = $this->postJson(
            route('api.closing-stores.closing-couriers.store', [
                $closingStore,
                $closingCourier,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $closingStore
                ->closingCouriers()
                ->where('closing_couriers.id', $closingCourier->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_closing_couriers_from_closing_store()
    {
        $closingStore = ClosingStore::factory()->create();
        $closingCourier = ClosingCourier::factory()->create();

        $response = $this->deleteJson(
            route('api.closing-stores.closing-couriers.store', [
                $closingStore,
                $closingCourier,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $closingStore
                ->closingCouriers()
                ->where('closing_couriers.id', $closingCourier->id)
                ->exists()
        );
    }
}
