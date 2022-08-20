<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\MovementAssetResult;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserMovementAssetResultsTest extends TestCase
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
    public function it_gets_user_movement_asset_results()
    {
        $user = User::factory()->create();
        $movementAssetResults = MovementAssetResult::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.movement-asset-results.index', $user)
        );

        $response->assertOk()->assertSee($movementAssetResults[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_user_movement_asset_results()
    {
        $user = User::factory()->create();
        $data = MovementAssetResult::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.movement-asset-results.store', $user),
            $data
        );

        $this->assertDatabaseHas('movement_asset_results', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $movementAssetResult = MovementAssetResult::latest('id')->first();

        $this->assertEquals($user->id, $movementAssetResult->user_id);
    }
}
