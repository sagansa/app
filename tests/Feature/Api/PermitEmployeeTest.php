<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\PermitEmployee;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermitEmployeeTest extends TestCase
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
    public function it_gets_permit_employees_list()
    {
        $permitEmployees = PermitEmployee::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.permit-employees.index'));

        $response->assertOk()->assertSee($permitEmployees[0]->from_date);
    }

    /**
     * @test
     */
    public function it_stores_the_permit_employee()
    {
        $data = PermitEmployee::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.permit-employees.store'), $data);

        unset($data['approved_by_id']);

        $this->assertDatabaseHas('permit_employees', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.permit-employees.update', $permitEmployee),
            $data
        );

        unset($data['approved_by_id']);

        $data['id'] = $permitEmployee->id;

        $this->assertDatabaseHas('permit_employees', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_permit_employee()
    {
        $permitEmployee = PermitEmployee::factory()->create();

        $response = $this->deleteJson(
            route('api.permit-employees.destroy', $permitEmployee)
        );

        $this->assertModelMissing($permitEmployee);

        $response->assertNoContent();
    }
}
