<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Customer;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerControllerTest extends TestCase
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
    public function it_displays_index_view_with_customers()
    {
        $customers = Customer::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('customers.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.customers.index')
            ->assertViewHas('customers');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_customer()
    {
        $response = $this->get(route('customers.create'));

        $response->assertOk()->assertViewIs('app.customers.create');
    }

    /**
     * @test
     */
    public function it_stores_the_customer()
    {
        $data = Customer::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('customers.store'), $data);

        unset($data['user_id']);

        $this->assertDatabaseHas('customers', $data);

        $customer = Customer::latest('id')->first();

        $response->assertRedirect(route('customers.edit', $customer));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_customer()
    {
        $customer = Customer::factory()->create();

        $response = $this->get(route('customers.show', $customer));

        $response
            ->assertOk()
            ->assertViewIs('app.customers.show')
            ->assertViewHas('customer');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_customer()
    {
        $customer = Customer::factory()->create();

        $response = $this->get(route('customers.edit', $customer));

        $response
            ->assertOk()
            ->assertViewIs('app.customers.edit')
            ->assertViewHas('customer');
    }

    /**
     * @test
     */
    public function it_updates_the_customer()
    {
        $customer = Customer::factory()->create();

        $user = User::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'no_telp' => $this->faker->unique->phoneNumber,
            'status' => $this->faker->numberBetween(1, 3),
            'user_id' => $user->id,
        ];

        $response = $this->put(route('customers.update', $customer), $data);

        unset($data['user_id']);

        $data['id'] = $customer->id;

        $this->assertDatabaseHas('customers', $data);

        $response->assertRedirect(route('customers.edit', $customer));
    }

    /**
     * @test
     */
    public function it_deletes_the_customer()
    {
        $customer = Customer::factory()->create();

        $response = $this->delete(route('customers.destroy', $customer));

        $response->assertRedirect(route('customers.index'));

        $this->assertModelMissing($customer);
    }
}
