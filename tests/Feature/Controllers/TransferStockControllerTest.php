<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\TransferStock;

use App\Models\Store;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransferStockControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_transfer_stocks()
    {
        $transferStocks = TransferStock::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('transfer-stocks.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.transfer_stocks.index')
            ->assertViewHas('transferStocks');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_transfer_stock()
    {
        $response = $this->get(route('transfer-stocks.create'));

        $response->assertOk()->assertViewIs('app.transfer_stocks.create');
    }

    /**
     * @test
     */
    public function it_stores_the_transfer_stock()
    {
        $data = TransferStock::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('transfer-stocks.store'), $data);

        unset($data['image']);

        $this->assertDatabaseHas('transfer_stocks', $data);

        $transferStock = TransferStock::latest('id')->first();

        $response->assertRedirect(
            route('transfer-stocks.edit', $transferStock)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_transfer_stock()
    {
        $transferStock = TransferStock::factory()->create();

        $response = $this->get(route('transfer-stocks.show', $transferStock));

        $response
            ->assertOk()
            ->assertViewIs('app.transfer_stocks.show')
            ->assertViewHas('transferStock');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_transfer_stock()
    {
        $transferStock = TransferStock::factory()->create();

        $response = $this->get(route('transfer-stocks.edit', $transferStock));

        $response
            ->assertOk()
            ->assertViewIs('app.transfer_stocks.edit')
            ->assertViewHas('transferStock');
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

        $response = $this->put(
            route('transfer-stocks.update', $transferStock),
            $data
        );

        unset($data['image']);

        $data['id'] = $transferStock->id;

        $this->assertDatabaseHas('transfer_stocks', $data);

        $response->assertRedirect(
            route('transfer-stocks.edit', $transferStock)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_transfer_stock()
    {
        $transferStock = TransferStock::factory()->create();

        $response = $this->delete(
            route('transfer-stocks.destroy', $transferStock)
        );

        $response->assertRedirect(route('transfer-stocks.index'));

        $this->assertModelMissing($transferStock);
    }
}
