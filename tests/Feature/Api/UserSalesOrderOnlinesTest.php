<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SalesOrderOnline;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserSalesOrderOnlinesTest extends TestCase
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
    public function it_gets_user_sales_order_onlines()
    {
        $user = User::factory()->create();
        $salesOrderOnlines = SalesOrderOnline::factory()
            ->count(2)
            ->create([
                'approved_by_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.sales-order-onlines.index', $user)
        );

        $response->assertOk()->assertSee($salesOrderOnlines[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_user_sales_order_onlines()
    {
        $user = User::factory()->create();
        $data = SalesOrderOnline::factory()
            ->make([
                'approved_by_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.sales-order-onlines.store', $user),
            $data
        );

        $this->assertDatabaseHas('sales_order_onlines', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $salesOrderOnline = SalesOrderOnline::latest('id')->first();

        $this->assertEquals($user->id, $salesOrderOnline->approved_by_id);
    }
}
