<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\OutInProduct;

use App\Models\StockCard;
use App\Models\DeliveryService;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OutInProductControllerTest extends TestCase
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
    public function it_displays_index_view_with_out_in_products()
    {
        $outInProducts = OutInProduct::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('out-in-products.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.out_in_products.index')
            ->assertViewHas('outInProducts');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_out_in_product()
    {
        $response = $this->get(route('out-in-products.create'));

        $response->assertOk()->assertViewIs('app.out_in_products.create');
    }

    /**
     * @test
     */
    public function it_stores_the_out_in_product()
    {
        $data = OutInProduct::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('out-in-products.store'), $data);

        unset($data['delivery_service_id']);

        $this->assertDatabaseHas('out_in_products', $data);

        $outInProduct = OutInProduct::latest('id')->first();

        $response->assertRedirect(route('out-in-products.edit', $outInProduct));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_out_in_product()
    {
        $outInProduct = OutInProduct::factory()->create();

        $response = $this->get(route('out-in-products.show', $outInProduct));

        $response
            ->assertOk()
            ->assertViewIs('app.out_in_products.show')
            ->assertViewHas('outInProduct');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_out_in_product()
    {
        $outInProduct = OutInProduct::factory()->create();

        $response = $this->get(route('out-in-products.edit', $outInProduct));

        $response
            ->assertOk()
            ->assertViewIs('app.out_in_products.edit')
            ->assertViewHas('outInProduct');
    }

    /**
     * @test
     */
    public function it_updates_the_out_in_product()
    {
        $outInProduct = OutInProduct::factory()->create();

        $stockCard = StockCard::factory()->create();
        $user = User::factory()->create();
        $user = User::factory()->create();
        $deliveryService = DeliveryService::factory()->create();

        $data = [
            'out_in' => $this->faker->numberBetween(1, 2),
            're' => $this->faker->text(50),
            'status' => $this->faker->numberBetween(1, 4),
            'notes' => $this->faker->text,
            'stock_card_id' => $stockCard->id,
            'created_by_id' => $user->id,
            'approved_by_id' => $user->id,
            'delivery_service_id' => $deliveryService->id,
        ];

        $response = $this->put(
            route('out-in-products.update', $outInProduct),
            $data
        );

        unset($data['delivery_service_id']);

        $data['id'] = $outInProduct->id;

        $this->assertDatabaseHas('out_in_products', $data);

        $response->assertRedirect(route('out-in-products.edit', $outInProduct));
    }

    /**
     * @test
     */
    public function it_deletes_the_out_in_product()
    {
        $outInProduct = OutInProduct::factory()->create();

        $response = $this->delete(
            route('out-in-products.destroy', $outInProduct)
        );

        $response->assertRedirect(route('out-in-products.index'));

        $this->assertModelMissing($outInProduct);
    }
}
