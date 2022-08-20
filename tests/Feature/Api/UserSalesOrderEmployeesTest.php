<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SalesOrderEmployee;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserSalesOrderEmployeesTest extends TestCase
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
    public function it_gets_user_sales_order_employees()
    {
        $user = User::factory()->create();
        $salesOrderEmployees = SalesOrderEmployee::factory()
            ->count(2)
            ->create([
                'approved_by_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.sales-order-employees.index', $user)
        );

        $response->assertOk()->assertSee($salesOrderEmployees[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_user_sales_order_employees()
    {
        $user = User::factory()->create();
        $data = SalesOrderEmployee::factory()
            ->make([
                'approved_by_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.sales-order-employees.store', $user),
            $data
        );

        $this->assertDatabaseHas('sales_order_employees', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $salesOrderEmployee = SalesOrderEmployee::latest('id')->first();

        $this->assertEquals($user->id, $salesOrderEmployee->approved_by_id);
    }
}
