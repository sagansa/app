<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\RequestStock;

use App\Models\Store;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RequestStockTest extends TestCase
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
    public function it_gets_request_stocks_list()
    {
        $requestStocks = RequestStock::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.request-stocks.index'));

        $response->assertOk()->assertSee($requestStocks[0]->notes);
    }

    /**
     * @test
     */
    public function it_stores_the_request_stock()
    {
        $data = RequestStock::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.request-stocks.store'), $data);

        $this->assertDatabaseHas('request_stocks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_request_stock()
    {
        $requestStock = RequestStock::factory()->create();

        $store = Store::factory()->create();
        $user = User::factory()->create();
        $user = User::factory()->create();

        $data = [
            'status' => $this->faker->numberBetween(1, 4),
            'notes' => $this->faker->text,
            'store_id' => $store->id,
            'created_by_id' => $user->id,
            'approved_by_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.request-stocks.update', $requestStock),
            $data
        );

        $data['id'] = $requestStock->id;

        $this->assertDatabaseHas('request_stocks', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_request_stock()
    {
        $requestStock = RequestStock::factory()->create();

        $response = $this->deleteJson(
            route('api.request-stocks.destroy', $requestStock)
        );

        $this->assertModelMissing($requestStock);

        $response->assertNoContent();
    }
}
