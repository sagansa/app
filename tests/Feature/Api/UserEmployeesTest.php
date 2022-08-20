<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Employee;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserEmployeesTest extends TestCase
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
    public function it_gets_user_employees()
    {
        $user = User::factory()->create();
        $employees = Employee::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.employees.index', $user));

        $response->assertOk()->assertSee($employees[0]->identity_no);
    }

    /**
     * @test
     */
    public function it_stores_the_user_employees()
    {
        $user = User::factory()->create();
        $data = Employee::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.employees.store', $user),
            $data
        );

        unset($data['user_id']);

        $this->assertDatabaseHas('employees', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $employee = Employee::latest('id')->first();

        $this->assertEquals($user->id, $employee->user_id);
    }
}
