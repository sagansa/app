<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\MovementAssetResult;

use App\Models\Store;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MovementAssetResultTest extends TestCase
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
    public function it_gets_movement_asset_results_list()
    {
        $movementAssetResults = MovementAssetResult::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.movement-asset-results.index'));

        $response->assertOk()->assertSee($movementAssetResults[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_movement_asset_result()
    {
        $data = MovementAssetResult::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.movement-asset-results.store'),
            $data
        );

        $this->assertDatabaseHas('movement_asset_results', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_movement_asset_result()
    {
        $movementAssetResult = MovementAssetResult::factory()->create();

        $store = Store::factory()->create();
        $user = User::factory()->create();

        $data = [
            'date' => $this->faker->date,
            'status' => $this->faker->numberBetween(0, 127),
            'notes' => $this->faker->text,
            'store_id' => $store->id,
            'user_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.movement-asset-results.update', $movementAssetResult),
            $data
        );

        $data['id'] = $movementAssetResult->id;

        $this->assertDatabaseHas('movement_asset_results', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_movement_asset_result()
    {
        $movementAssetResult = MovementAssetResult::factory()->create();

        $response = $this->deleteJson(
            route('api.movement-asset-results.destroy', $movementAssetResult)
        );

        $this->assertModelMissing($movementAssetResult);

        $response->assertNoContent();
    }
}
