<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Employee;
use App\Models\EmployeeStatus;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeStatusEmployeesTest extends TestCase
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
    public function it_gets_employee_status_employees()
    {
        $employeeStatus = EmployeeStatus::factory()->create();
        $employees = Employee::factory()
            ->count(2)
            ->create([
                'employee_status_id' => $employeeStatus->id,
            ]);

        $response = $this->getJson(
            route('api.employee-statuses.employees.index', $employeeStatus)
        );

        $response->assertOk()->assertSee($employees[0]->identity_no);
    }

    /**
     * @test
     */
    public function it_stores_the_employee_status_employees()
    {
        $employeeStatus = EmployeeStatus::factory()->create();
        $data = Employee::factory()
            ->make([
                'employee_status_id' => $employeeStatus->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.employee-statuses.employees.store', $employeeStatus),
            $data
        );

        unset($data['user_id']);

        $this->assertDatabaseHas('employees', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $employee = Employee::latest('id')->first();

        $this->assertEquals($employeeStatus->id, $employee->employee_status_id);
    }
}
