<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\TransferDailySalary;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransferDailySalaryTest extends TestCase
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
    public function it_gets_transfer_daily_salaries_list()
    {
        $transferDailySalaries = TransferDailySalary::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.transfer-daily-salaries.index'));

        $response->assertOk()->assertSee($transferDailySalaries[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_transfer_daily_salary()
    {
        $data = TransferDailySalary::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.transfer-daily-salaries.store'),
            $data
        );

        $this->assertDatabaseHas('transfer_daily_salaries', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_transfer_daily_salary()
    {
        $transferDailySalary = TransferDailySalary::factory()->create();

        $data = [
            'image' => $this->faker->text(255),
            'amount' => $this->faker->randomNumber,
        ];

        $response = $this->putJson(
            route('api.transfer-daily-salaries.update', $transferDailySalary),
            $data
        );

        $data['id'] = $transferDailySalary->id;

        $this->assertDatabaseHas('transfer_daily_salaries', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_transfer_daily_salary()
    {
        $transferDailySalary = TransferDailySalary::factory()->create();

        $response = $this->deleteJson(
            route('api.transfer-daily-salaries.destroy', $transferDailySalary)
        );

        $this->assertModelMissing($transferDailySalary);

        $response->assertNoContent();
    }
}
