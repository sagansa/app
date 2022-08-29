<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\UtilityBill;

use App\Models\Utility;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UtilityBillControllerTest extends TestCase
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
    public function it_displays_index_view_with_utility_bills()
    {
        $utilityBills = UtilityBill::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('utility-bills.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.utility_bills.index')
            ->assertViewHas('utilityBills');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_utility_bill()
    {
        $response = $this->get(route('utility-bills.create'));

        $response->assertOk()->assertViewIs('app.utility_bills.create');
    }

    /**
     * @test
     */
    public function it_stores_the_utility_bill()
    {
        $data = UtilityBill::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('utility-bills.store'), $data);

        $this->assertDatabaseHas('utility_bills', $data);

        $utilityBill = UtilityBill::latest('id')->first();

        $response->assertRedirect(route('utility-bills.edit', $utilityBill));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_utility_bill()
    {
        $utilityBill = UtilityBill::factory()->create();

        $response = $this->get(route('utility-bills.show', $utilityBill));

        $response
            ->assertOk()
            ->assertViewIs('app.utility_bills.show')
            ->assertViewHas('utilityBill');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_utility_bill()
    {
        $utilityBill = UtilityBill::factory()->create();

        $response = $this->get(route('utility-bills.edit', $utilityBill));

        $response
            ->assertOk()
            ->assertViewIs('app.utility_bills.edit')
            ->assertViewHas('utilityBill');
    }

    /**
     * @test
     */
    public function it_updates_the_utility_bill()
    {
        $utilityBill = UtilityBill::factory()->create();

        $utility = Utility::factory()->create();

        $data = [
            'date' => $this->faker->date,
            'amount' => $this->faker->text(255),
            'initial_indicator' => $this->faker->randomNumber(2),
            'last_indicator' => $this->faker->randomNumber(2),
            'utility_id' => $utility->id,
        ];

        $response = $this->put(
            route('utility-bills.update', $utilityBill),
            $data
        );

        $data['id'] = $utilityBill->id;

        $this->assertDatabaseHas('utility_bills', $data);

        $response->assertRedirect(route('utility-bills.edit', $utilityBill));
    }

    /**
     * @test
     */
    public function it_deletes_the_utility_bill()
    {
        $utilityBill = UtilityBill::factory()->create();

        $response = $this->delete(route('utility-bills.destroy', $utilityBill));

        $response->assertRedirect(route('utility-bills.index'));

        $this->assertModelMissing($utilityBill);
    }
}
