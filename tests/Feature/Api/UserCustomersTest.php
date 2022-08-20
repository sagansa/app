<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Customer;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserCustomersTest extends TestCase
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
    public function it_gets_user_customers()
    {
        $user = User::factory()->create();
        $customers = Customer::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.customers.index', $user));

        $response->assertOk()->assertSee($customers[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_user_customers()
    {
        $user = User::factory()->create();
        $data = Customer::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.customers.store', $user),
            $data
        );

        unset($data['user_id']);

        $this->assertDatabaseHas('customers', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $customer = Customer::latest('id')->first();

        $this->assertEquals($user->id, $customer->user_id);
    }
}
