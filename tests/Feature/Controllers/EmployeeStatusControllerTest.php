<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\EmployeeStatus;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeStatusControllerTest extends TestCase
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
    public function it_displays_index_view_with_employee_statuses()
    {
        $employeeStatuses = EmployeeStatus::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('employee-statuses.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.employee_statuses.index')
            ->assertViewHas('employeeStatuses');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_employee_status()
    {
        $response = $this->get(route('employee-statuses.create'));

        $response->assertOk()->assertViewIs('app.employee_statuses.create');
    }

    /**
     * @test
     */
    public function it_stores_the_employee_status()
    {
        $data = EmployeeStatus::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('employee-statuses.store'), $data);

        $this->assertDatabaseHas('employee_statuses', $data);

        $employeeStatus = EmployeeStatus::latest('id')->first();

        $response->assertRedirect(
            route('employee-statuses.edit', $employeeStatus)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_employee_status()
    {
        $employeeStatus = EmployeeStatus::factory()->create();

        $response = $this->get(
            route('employee-statuses.show', $employeeStatus)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.employee_statuses.show')
            ->assertViewHas('employeeStatus');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_employee_status()
    {
        $employeeStatus = EmployeeStatus::factory()->create();

        $response = $this->get(
            route('employee-statuses.edit', $employeeStatus)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.employee_statuses.edit')
            ->assertViewHas('employeeStatus');
    }

    /**
     * @test
     */
    public function it_updates_the_employee_status()
    {
        $employeeStatus = EmployeeStatus::factory()->create();

        $data = [
            'name' => $this->faker->name,
        ];

        $response = $this->put(
            route('employee-statuses.update', $employeeStatus),
            $data
        );

        $data['id'] = $employeeStatus->id;

        $this->assertDatabaseHas('employee_statuses', $data);

        $response->assertRedirect(
            route('employee-statuses.edit', $employeeStatus)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_employee_status()
    {
        $employeeStatus = EmployeeStatus::factory()->create();

        $response = $this->delete(
            route('employee-statuses.destroy', $employeeStatus)
        );

        $response->assertRedirect(route('employee-statuses.index'));

        $this->assertModelMissing($employeeStatus);
    }
}
