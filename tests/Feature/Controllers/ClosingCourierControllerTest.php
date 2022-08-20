<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ClosingCourier;

use App\Models\Bank;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClosingCourierControllerTest extends TestCase
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
    public function it_displays_index_view_with_closing_couriers()
    {
        $closingCouriers = ClosingCourier::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('closing-couriers.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.closing_couriers.index')
            ->assertViewHas('closingCouriers');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_closing_courier()
    {
        $response = $this->get(route('closing-couriers.create'));

        $response->assertOk()->assertViewIs('app.closing_couriers.create');
    }

    /**
     * @test
     */
    public function it_stores_the_closing_courier()
    {
        $data = ClosingCourier::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('closing-couriers.store'), $data);

        unset($data['created_by_id']);
        unset($data['approved_by_id']);

        $this->assertDatabaseHas('closing_couriers', $data);

        $closingCourier = ClosingCourier::latest('id')->first();

        $response->assertRedirect(
            route('closing-couriers.edit', $closingCourier)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_closing_courier()
    {
        $closingCourier = ClosingCourier::factory()->create();

        $response = $this->get(route('closing-couriers.show', $closingCourier));

        $response
            ->assertOk()
            ->assertViewIs('app.closing_couriers.show')
            ->assertViewHas('closingCourier');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_closing_courier()
    {
        $closingCourier = ClosingCourier::factory()->create();

        $response = $this->get(route('closing-couriers.edit', $closingCourier));

        $response
            ->assertOk()
            ->assertViewIs('app.closing_couriers.edit')
            ->assertViewHas('closingCourier');
    }

    /**
     * @test
     */
    public function it_updates_the_closing_courier()
    {
        $closingCourier = ClosingCourier::factory()->create();

        $bank = Bank::factory()->create();
        $user = User::factory()->create();
        $user = User::factory()->create();

        $data = [
            'total_cash_to_transfer' => $this->faker->randomNumber,
            'status' => $this->faker->numberBetween(1, 4),
            'notes' => $this->faker->text,
            'bank_id' => $bank->id,
            'created_by_id' => $user->id,
            'approved_by_id' => $user->id,
        ];

        $response = $this->put(
            route('closing-couriers.update', $closingCourier),
            $data
        );

        unset($data['created_by_id']);
        unset($data['approved_by_id']);

        $data['id'] = $closingCourier->id;

        $this->assertDatabaseHas('closing_couriers', $data);

        $response->assertRedirect(
            route('closing-couriers.edit', $closingCourier)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_closing_courier()
    {
        $closingCourier = ClosingCourier::factory()->create();

        $response = $this->delete(
            route('closing-couriers.destroy', $closingCourier)
        );

        $response->assertRedirect(route('closing-couriers.index'));

        $this->assertModelMissing($closingCourier);
    }
}
