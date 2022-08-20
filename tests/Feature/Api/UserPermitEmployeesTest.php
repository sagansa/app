<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\PermitEmployee;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserPermitEmployeesTest extends TestCase
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
    public function it_gets_user_permit_employees()
    {
        $user = User::factory()->create();
        $permitEmployees = PermitEmployee::factory()
            ->count(2)
            ->create([
                'approved_by_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.permit-employees.index', $user)
        );

        $response->assertOk()->assertSee($permitEmployees[0]->from_date);
    }

    /**
     * @test
     */
    public function it_stores_the_user_permit_employees()
    {
        $user = User::factory()->create();
        $data = PermitEmployee::factory()
            ->make([
                'approved_by_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.permit-employees.store', $user),
            $data
        );

        unset($data['approved_by_id']);

        $this->assertDatabaseHas('permit_employees', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $permitEmployee = PermitEmployee::latest('id')->first();

        $this->assertEquals($user->id, $permitEmployee->approved_by_id);
    }
}
