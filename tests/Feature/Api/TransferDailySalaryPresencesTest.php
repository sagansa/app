<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Presence;
use App\Models\TransferDailySalary;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransferDailySalaryPresencesTest extends TestCase
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
    public function it_gets_transfer_daily_salary_presences()
    {
        $transferDailySalary = TransferDailySalary::factory()->create();
        $presence = Presence::factory()->create();

        $transferDailySalary->presences()->attach($presence);

        $response = $this->getJson(
            route(
                'api.transfer-daily-salaries.presences.index',
                $transferDailySalary
            )
        );

        $response->assertOk()->assertSee($presence->image_in);
    }

    /**
     * @test
     */
    public function it_can_attach_presences_to_transfer_daily_salary()
    {
        $transferDailySalary = TransferDailySalary::factory()->create();
        $presence = Presence::factory()->create();

        $response = $this->postJson(
            route('api.transfer-daily-salaries.presences.store', [
                $transferDailySalary,
                $presence,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $transferDailySalary
                ->presences()
                ->where('presences.id', $presence->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_presences_from_transfer_daily_salary()
    {
        $transferDailySalary = TransferDailySalary::factory()->create();
        $presence = Presence::factory()->create();

        $response = $this->deleteJson(
            route('api.transfer-daily-salaries.presences.store', [
                $transferDailySalary,
                $presence,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $transferDailySalary
                ->presences()
                ->where('presences.id', $presence->id)
                ->exists()
        );
    }
}
