<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\PaymentType;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentTypeControllerTest extends TestCase
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
    public function it_displays_index_view_with_payment_types()
    {
        $paymentTypes = PaymentType::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('payment-types.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.payment_types.index')
            ->assertViewHas('paymentTypes');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_payment_type()
    {
        $response = $this->get(route('payment-types.create'));

        $response->assertOk()->assertViewIs('app.payment_types.create');
    }

    /**
     * @test
     */
    public function it_stores_the_payment_type()
    {
        $data = PaymentType::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('payment-types.store'), $data);

        $this->assertDatabaseHas('payment_types', $data);

        $paymentType = PaymentType::latest('id')->first();

        $response->assertRedirect(route('payment-types.edit', $paymentType));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_payment_type()
    {
        $paymentType = PaymentType::factory()->create();

        $response = $this->get(route('payment-types.show', $paymentType));

        $response
            ->assertOk()
            ->assertViewIs('app.payment_types.show')
            ->assertViewHas('paymentType');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_payment_type()
    {
        $paymentType = PaymentType::factory()->create();

        $response = $this->get(route('payment-types.edit', $paymentType));

        $response
            ->assertOk()
            ->assertViewIs('app.payment_types.edit')
            ->assertViewHas('paymentType');
    }

    /**
     * @test
     */
    public function it_updates_the_payment_type()
    {
        $paymentType = PaymentType::factory()->create();

        $data = [
            'name' => $this->faker->text(10),
            'status' => $this->faker->numberBetween(1, 2),
        ];

        $response = $this->put(
            route('payment-types.update', $paymentType),
            $data
        );

        $data['id'] = $paymentType->id;

        $this->assertDatabaseHas('payment_types', $data);

        $response->assertRedirect(route('payment-types.edit', $paymentType));
    }

    /**
     * @test
     */
    public function it_deletes_the_payment_type()
    {
        $paymentType = PaymentType::factory()->create();

        $response = $this->delete(route('payment-types.destroy', $paymentType));

        $response->assertRedirect(route('payment-types.index'));

        $this->assertModelMissing($paymentType);
    }
}
