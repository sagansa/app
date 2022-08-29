<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Store;
use App\Models\SalesOrderOnline;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreSalesOrderOnlinesTest extends TestCase
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
    public function it_gets_store_sales_order_onlines()
    {
        $store = Store::factory()->create();
        $salesOrderOnlines = SalesOrderOnline::factory()
            ->count(2)
            ->create([
                'store_id' => $store->id,
            ]);

        $response = $this->getJson(
            route('api.stores.sales-order-onlines.index', $store)
        );

        $response->assertOk()->assertSee($salesOrderOnlines[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_store_sales_order_onlines()
    {
        $store = Store::factory()->create();
        $data = SalesOrderOnline::factory()
            ->make([
                'store_id' => $store->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.stores.sales-order-onlines.store', $store),
            $data
        );

        $this->assertDatabaseHas('sales_order_onlines', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $salesOrderOnline = SalesOrderOnline::latest('id')->first();

        $this->assertEquals($store->id, $salesOrderOnline->store_id);
    }
}
