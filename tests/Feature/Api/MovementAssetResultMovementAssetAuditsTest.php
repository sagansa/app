<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\MovementAssetAudit;
use App\Models\MovementAssetResult;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MovementAssetResultMovementAssetAuditsTest extends TestCase
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
    public function it_gets_movement_asset_result_movement_asset_audits()
    {
        $movementAssetResult = MovementAssetResult::factory()->create();
        $movementAssetAudits = MovementAssetAudit::factory()
            ->count(2)
            ->create([
                'movement_asset_result_id' => $movementAssetResult->id,
            ]);

        $response = $this->getJson(
            route(
                'api.movement-asset-results.movement-asset-audits.index',
                $movementAssetResult
            )
        );

        $response->assertOk()->assertSee($movementAssetAudits[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_movement_asset_result_movement_asset_audits()
    {
        $movementAssetResult = MovementAssetResult::factory()->create();
        $data = MovementAssetAudit::factory()
            ->make([
                'movement_asset_result_id' => $movementAssetResult->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route(
                'api.movement-asset-results.movement-asset-audits.store',
                $movementAssetResult
            ),
            $data
        );

        unset($data['movement_asset_result_id']);

        $this->assertDatabaseHas('movement_asset_audits', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $movementAssetAudit = MovementAssetAudit::latest('id')->first();

        $this->assertEquals(
            $movementAssetResult->id,
            $movementAssetAudit->movement_asset_result_id
        );
    }
}
