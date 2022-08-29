<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\OutInProduct;

use App\Models\StockCard;
use App\Models\DeliveryService;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OutInProductTest extends TestCase
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
    public function it_gets_out_in_products_list()
    {
        $outInProducts = OutInProduct::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.out-in-products.index'));

        $response->assertOk()->assertSee($outInProducts[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_out_in_product()
    {
        $data = OutInProduct::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.out-in-products.store'), $data);

        unset($data['delivery_service_id']);

        $this->assertDatabaseHas('out_in_products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.out-in-products.update', $outInProduct),
            $data
        );

        unset($data['delivery_service_id']);

        $data['id'] = $outInProduct->id;

        $this->assertDatabaseHas('out_in_products', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_out_in_product()
    {
        $outInProduct = OutInProduct::factory()->create();

        $response = $this->deleteJson(
            route('api.out-in-products.destroy', $outInProduct)
        );

        $this->assertModelMissing($outInProduct);

        $response->assertNoContent();
    }
}
