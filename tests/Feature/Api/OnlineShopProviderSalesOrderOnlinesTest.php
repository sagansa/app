<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SalesOrderOnline;
use App\Models\OnlineShopProvider;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OnlineShopProviderSalesOrderOnlinesTest extends TestCase
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
    public function it_gets_online_shop_provider_sales_order_onlines()
    {
        $onlineShopProvider = OnlineShopProvider::factory()->create();
        $salesOrderOnlines = SalesOrderOnline::factory()
            ->count(2)
            ->create([
                'online_shop_provider_id' => $onlineShopProvider->id,
            ]);

        $response = $this->getJson(
            route(
                'api.online-shop-providers.sales-order-onlines.index',
                $onlineShopProvider
            )
        );

        $response->assertOk()->assertSee($salesOrderOnlines[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_online_shop_provider_sales_order_onlines()
    {
        $onlineShopProvider = OnlineShopProvider::factory()->create();
        $data = SalesOrderOnline::factory()
            ->make([
                'online_shop_provider_id' => $onlineShopProvider->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route(
                'api.online-shop-providers.sales-order-onlines.store',
                $onlineShopProvider
            ),
            $data
        );

        $this->assertDatabaseHas('sales_order_onlines', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $salesOrderOnline = SalesOrderOnline::latest('id')->first();

        $this->assertEquals(
            $onlineShopProvider->id,
            $salesOrderOnline->online_shop_provider_id
        );
    }
}
