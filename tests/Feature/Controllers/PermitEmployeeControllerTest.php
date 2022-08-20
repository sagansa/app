<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\PermitEmployee;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermitEmployeeControllerTest extends TestCase
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
    public function it_displays_index_view_with_permit_employees()
    {
        $permitEmployees = PermitEmployee::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('permit-employees.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.permit_employees.index')
            ->assertViewHas('permitEmployees');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_permit_employee()
    {
        $response = $this->get(route('permit-employees.create'));

        $response->assertOk()->assertViewIs('app.permit_employees.create');
    }

    /**
     * @test
     */
    public function it_stores_the_permit_employee()
    {
        $data = PermitEmployee::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('permit-employees.store'), $data);

        unset($data['approved_by_id']);

        $this->assertDatabaseHas('permit_employees', $data);

        $permitEmployee = PermitEmployee::latest('id')->first();

        $response->assertRedirect(
            route('permit-employees.edit', $permitEmployee)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_permit_employee()
    {
        $permitEmployee = PermitEmployee::factory()->create();

        $response = $this->get(route('permit-employees.show', $permitEmployee));

        $response
            ->assertOk()
            ->assertViewIs('app.permit_employees.show')
            ->assertViewHas('permitEmployee');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_permit_employee()
    {
        $permitEmployee = PermitEmployee::factory()->create();

        $response = $this->get(route('permit-employees.edit', $permitEmployee));

        $response
            ->assertOk()
            ->assertViewIs('app.permit_employees.edit')
            ->assertViewHas('permitEmployee');
    }

    /**
     * @test
     */
    public function it_updates_the_permit_employee()
    {
        $permitEmployee = PermitEmployee::factory()->create();

        $user = User::factory()->create();
        $user = User::factory()->create();

        $data = [
            'reason' => $this->faker->numberBetween(1, 7),
            'from_date' => $this->faker->date,
            'until_date' => $this->faker->date,
            'status' => $this->faker->numberBetween(1, 2),
            'notes' => $this->faker->text,
            'created_by_id' => $user->id,
            'approved_by_id' => $user->id,
        ];

        $response = $this->put(
            route('permit-employees.update', $permitEmployee),
            $data
        );

        unset($data['approved_by_id']);

        $data['id'] = $permitEmployee->id;

        $this->assertDatabaseHas('permit_employees', $data);

        $response->assertRedirect(
            route('permit-employees.edit', $permitEmployee)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_permit_employee()
    {
        $permitEmployee = PermitEmployee::factory()->create();

        $response = $this->delete(
            route('permit-employees.destroy', $permitEmployee)
        );

        $response->assertRedirect(route('permit-employees.index'));

        $this->assertModelMissing($permitEmployee);
    }
}
