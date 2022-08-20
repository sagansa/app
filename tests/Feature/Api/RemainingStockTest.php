<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\RemainingStock;

use App\Models\Store;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RemainingStockTest extends TestCase
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
    public function it_gets_remaining_stocks_list()
    {
        $remainingStocks = RemainingStock::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.remaining-stocks.index'));

        $response->assertOk()->assertSee($remainingStocks[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_remaining_stock()
    {
        $data = RemainingStock::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.remaining-stocks.store'), $data);

        $this->assertDatabaseHas('remaining_stocks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_remaining_stock()
    {
        $remainingStock = RemainingStock::factory()->create();

        $store = Store::factory()->create();
        $user = User::factory()->create();
        $user = User::factory()->create();

        $data = [
            'date' => $this->faker->date,
            'status' => $this->faker->numberBetween(1, 4),
            'notes' => $this->faker->text,
            'store_id' => $store->id,
            'created_by_id' => $user->id,
            'approved_by_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.remaining-stocks.update', $remainingStock),
            $data
        );

        $data['id'] = $remainingStock->id;

        $this->assertDatabaseHas('remaining_stocks', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_remaining_stock()
    {
        $remainingStock = RemainingStock::factory()->create();

        $response = $this->deleteJson(
            route('api.remaining-stocks.destroy', $remainingStock)
        );

        $this->assertModelMissing($remainingStock);

        $response->assertNoContent();
    }
}
