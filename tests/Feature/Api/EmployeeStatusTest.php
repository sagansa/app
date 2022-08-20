<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\EmployeeStatus;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeStatusTest extends TestCase
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
    public function it_gets_employee_statuses_list()
    {
        $employeeStatuses = EmployeeStatus::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.employee-statuses.index'));

        $response->assertOk()->assertSee($employeeStatuses[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_employee_status()
    {
        $data = EmployeeStatus::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.employee-statuses.store'),
            $data
        );

        $this->assertDatabaseHas('employee_statuses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.employee-statuses.update', $employeeStatus),
            $data
        );

        $data['id'] = $employeeStatus->id;

        $this->assertDatabaseHas('employee_statuses', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_employee_status()
    {
        $employeeStatus = EmployeeStatus::factory()->create();

        $response = $this->deleteJson(
            route('api.employee-statuses.destroy', $employeeStatus)
        );

        $this->assertModelMissing($employeeStatus);

        $response->assertNoContent();
    }
}
