<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Bank;
use App\Models\Employee;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BankEmployeesTest extends TestCase
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
    public function it_gets_bank_employees()
    {
        $bank = Bank::factory()->create();
        $employees = Employee::factory()
            ->count(2)
            ->create([
                'bank_id' => $bank->id,
            ]);

        $response = $this->getJson(route('api.banks.employees.index', $bank));

        $response->assertOk()->assertSee($employees[0]->identity_no);
    }

    /**
     * @test
     */
    public function it_stores_the_bank_employees()
    {
        $bank = Bank::factory()->create();
        $data = Employee::factory()
            ->make([
                'bank_id' => $bank->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.banks.employees.store', $bank),
            $data
        );

        unset($data['user_id']);

        $this->assertDatabaseHas('employees', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $employee = Employee::latest('id')->first();

        $this->assertEquals($bank->id, $employee->bank_id);
    }
}
