<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\TransferDailySalary;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransferDailySalaryControllerTest extends TestCase
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
    public function it_displays_index_view_with_transfer_daily_salaries()
    {
        $transferDailySalaries = TransferDailySalary::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('transfer-daily-salaries.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.transfer_daily_salaries.index')
            ->assertViewHas('transferDailySalaries');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_transfer_daily_salary()
    {
        $response = $this->get(route('transfer-daily-salaries.create'));

        $response
            ->assertOk()
            ->assertViewIs('app.transfer_daily_salaries.create');
    }

    /**
     * @test
     */
    public function it_stores_the_transfer_daily_salary()
    {
        $data = TransferDailySalary::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('transfer-daily-salaries.store'), $data);

        $this->assertDatabaseHas('transfer_daily_salaries', $data);

        $transferDailySalary = TransferDailySalary::latest('id')->first();

        $response->assertRedirect(
            route('transfer-daily-salaries.edit', $transferDailySalary)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_transfer_daily_salary()
    {
        $transferDailySalary = TransferDailySalary::factory()->create();

        $response = $this->get(
            route('transfer-daily-salaries.show', $transferDailySalary)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.transfer_daily_salaries.show')
            ->assertViewHas('transferDailySalary');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_transfer_daily_salary()
    {
        $transferDailySalary = TransferDailySalary::factory()->create();

        $response = $this->get(
            route('transfer-daily-salaries.edit', $transferDailySalary)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.transfer_daily_salaries.edit')
            ->assertViewHas('transferDailySalary');
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

        $response = $this->put(
            route('transfer-daily-salaries.update', $transferDailySalary),
            $data
        );

        $data['id'] = $transferDailySalary->id;

        $this->assertDatabaseHas('transfer_daily_salaries', $data);

        $response->assertRedirect(
            route('transfer-daily-salaries.edit', $transferDailySalary)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_transfer_daily_salary()
    {
        $transferDailySalary = TransferDailySalary::factory()->create();

        $response = $this->delete(
            route('transfer-daily-salaries.destroy', $transferDailySalary)
        );

        $response->assertRedirect(route('transfer-daily-salaries.index'));

        $this->assertModelMissing($transferDailySalary);
    }
}
