<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\RemainingStock;

use App\Models\Store;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RemainingStockControllerTest extends TestCase
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
    public function it_displays_index_view_with_remaining_stocks()
    {
        $remainingStocks = RemainingStock::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('remaining-stocks.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.remaining_stocks.index')
            ->assertViewHas('remainingStocks');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_remaining_stock()
    {
        $response = $this->get(route('remaining-stocks.create'));

        $response->assertOk()->assertViewIs('app.remaining_stocks.create');
    }

    /**
     * @test
     */
    public function it_stores_the_remaining_stock()
    {
        $data = RemainingStock::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('remaining-stocks.store'), $data);

        $this->assertDatabaseHas('remaining_stocks', $data);

        $remainingStock = RemainingStock::latest('id')->first();

        $response->assertRedirect(
            route('remaining-stocks.edit', $remainingStock)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_remaining_stock()
    {
        $remainingStock = RemainingStock::factory()->create();

        $response = $this->get(route('remaining-stocks.show', $remainingStock));

        $response
            ->assertOk()
            ->assertViewIs('app.remaining_stocks.show')
            ->assertViewHas('remainingStock');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_remaining_stock()
    {
        $remainingStock = RemainingStock::factory()->create();

        $response = $this->get(route('remaining-stocks.edit', $remainingStock));

        $response
            ->assertOk()
            ->assertViewIs('app.remaining_stocks.edit')
            ->assertViewHas('remainingStock');
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

        $response = $this->put(
            route('remaining-stocks.update', $remainingStock),
            $data
        );

        $data['id'] = $remainingStock->id;

        $this->assertDatabaseHas('remaining_stocks', $data);

        $response->assertRedirect(
            route('remaining-stocks.edit', $remainingStock)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_remaining_stock()
    {
        $remainingStock = RemainingStock::factory()->create();

        $response = $this->delete(
            route('remaining-stocks.destroy', $remainingStock)
        );

        $response->assertRedirect(route('remaining-stocks.index'));

        $this->assertModelMissing($remainingStock);
    }
}
