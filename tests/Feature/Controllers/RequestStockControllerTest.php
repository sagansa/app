<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\RequestStock;

use App\Models\Store;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RequestStockControllerTest extends TestCase
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
    public function it_displays_index_view_with_request_stocks()
    {
        $requestStocks = RequestStock::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('request-stocks.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.request_stocks.index')
            ->assertViewHas('requestStocks');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_request_stock()
    {
        $response = $this->get(route('request-stocks.create'));

        $response->assertOk()->assertViewIs('app.request_stocks.create');
    }

    /**
     * @test
     */
    public function it_stores_the_request_stock()
    {
        $data = RequestStock::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('request-stocks.store'), $data);

        $this->assertDatabaseHas('request_stocks', $data);

        $requestStock = RequestStock::latest('id')->first();

        $response->assertRedirect(route('request-stocks.edit', $requestStock));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_request_stock()
    {
        $requestStock = RequestStock::factory()->create();

        $response = $this->get(route('request-stocks.show', $requestStock));

        $response
            ->assertOk()
            ->assertViewIs('app.request_stocks.show')
            ->assertViewHas('requestStock');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_request_stock()
    {
        $requestStock = RequestStock::factory()->create();

        $response = $this->get(route('request-stocks.edit', $requestStock));

        $response
            ->assertOk()
            ->assertViewIs('app.request_stocks.edit')
            ->assertViewHas('requestStock');
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

        $response = $this->put(
            route('request-stocks.update', $requestStock),
            $data
        );

        $data['id'] = $requestStock->id;

        $this->assertDatabaseHas('request_stocks', $data);

        $response->assertRedirect(route('request-stocks.edit', $requestStock));
    }

    /**
     * @test
     */
    public function it_deletes_the_request_stock()
    {
        $requestStock = RequestStock::factory()->create();

        $response = $this->delete(
            route('request-stocks.destroy', $requestStock)
        );

        $response->assertRedirect(route('request-stocks.index'));

        $this->assertModelMissing($requestStock);
    }
}
