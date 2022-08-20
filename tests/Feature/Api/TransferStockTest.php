<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\TransferStock;

use App\Models\Store;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransferStockTest extends TestCase
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
    public function it_gets_transfer_stocks_list()
    {
        $transferStocks = TransferStock::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.transfer-stocks.index'));

        $response->assertOk()->assertSee($transferStocks[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_transfer_stock()
    {
        $data = TransferStock::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.transfer-stocks.store'), $data);

        unset($data['image']);

        $this->assertDatabaseHas('transfer_stocks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_transfer_stock()
    {
        $transferStock = TransferStock::factory()->create();

        $store = Store::factory()->create();
        $store = Store::factory()->create();
        $user = User::factory()->create();
        $user = User::factory()->create();
        $user = User::factory()->create();

        $data = [
            'date' => $this->faker->date,
            'status' => $this->faker->numberBetween(1, 4),
            'notes' => $this->faker->text,
            'from_store_id' => $store->id,
            'to_store_id' => $store->id,
            'approved_by_id' => $user->id,
            'received_by_id' => $user->id,
            'sent_by_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.transfer-stocks.update', $transferStock),
            $data
        );

        unset($data['image']);

        $data['id'] = $transferStock->id;

        $this->assertDatabaseHas('transfer_stocks', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_transfer_stock()
    {
        $transferStock = TransferStock::factory()->create();

        $response = $this->deleteJson(
            route('api.transfer-stocks.destroy', $transferStock)
        );

        $this->assertModelMissing($transferStock);

        $response->assertNoContent();
    }
}
