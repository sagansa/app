<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\MovementAssetResult;

use App\Models\Store;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MovementAssetResultControllerTest extends TestCase
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
    public function it_displays_index_view_with_movement_asset_results()
    {
        $movementAssetResults = MovementAssetResult::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('movement-asset-results.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.movement_asset_results.index')
            ->assertViewHas('movementAssetResults');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_movement_asset_result()
    {
        $response = $this->get(route('movement-asset-results.create'));

        $response
            ->assertOk()
            ->assertViewIs('app.movement_asset_results.create');
    }

    /**
     * @test
     */
    public function it_stores_the_movement_asset_result()
    {
        $data = MovementAssetResult::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('movement-asset-results.store'), $data);

        $this->assertDatabaseHas('movement_asset_results', $data);

        $movementAssetResult = MovementAssetResult::latest('id')->first();

        $response->assertRedirect(
            route('movement-asset-results.edit', $movementAssetResult)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_movement_asset_result()
    {
        $movementAssetResult = MovementAssetResult::factory()->create();

        $response = $this->get(
            route('movement-asset-results.show', $movementAssetResult)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.movement_asset_results.show')
            ->assertViewHas('movementAssetResult');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_movement_asset_result()
    {
        $movementAssetResult = MovementAssetResult::factory()->create();

        $response = $this->get(
            route('movement-asset-results.edit', $movementAssetResult)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.movement_asset_results.edit')
            ->assertViewHas('movementAssetResult');
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

        $response = $this->put(
            route('movement-asset-results.update', $movementAssetResult),
            $data
        );

        $data['id'] = $movementAssetResult->id;

        $this->assertDatabaseHas('movement_asset_results', $data);

        $response->assertRedirect(
            route('movement-asset-results.edit', $movementAssetResult)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_movement_asset_result()
    {
        $movementAssetResult = MovementAssetResult::factory()->create();

        $response = $this->delete(
            route('movement-asset-results.destroy', $movementAssetResult)
        );

        $response->assertRedirect(route('movement-asset-results.index'));

        $this->assertModelMissing($movementAssetResult);
    }
}
