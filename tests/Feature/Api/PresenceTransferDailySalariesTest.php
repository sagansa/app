<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Presence;
use App\Models\TransferDailySalary;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PresenceTransferDailySalariesTest extends TestCase
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
    public function it_gets_presence_transfer_daily_salaries()
    {
        $presence = Presence::factory()->create();
        $transferDailySalary = TransferDailySalary::factory()->create();

        $presence->transferDailySalaries()->attach($transferDailySalary);

        $response = $this->getJson(
            route('api.presences.transfer-daily-salaries.index', $presence)
        );

        $response->assertOk()->assertSee($transferDailySalary->image);
    }

    /**
     * @test
     */
    public function it_can_attach_transfer_daily_salaries_to_presence()
    {
        $presence = Presence::factory()->create();
        $transferDailySalary = TransferDailySalary::factory()->create();

        $response = $this->postJson(
            route('api.presences.transfer-daily-salaries.store', [
                $presence,
                $transferDailySalary,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $presence
                ->transferDailySalaries()
                ->where('transfer_daily_salaries.id', $transferDailySalary->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_transfer_daily_salaries_from_presence()
    {
        $presence = Presence::factory()->create();
        $transferDailySalary = TransferDailySalary::factory()->create();

        $response = $this->deleteJson(
            route('api.presences.transfer-daily-salaries.store', [
                $presence,
                $transferDailySalary,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $presence
                ->transferDailySalaries()
                ->where('transfer_daily_salaries.id', $transferDailySalary->id)
                ->exists()
        );
    }
}
