<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\MovementAsset;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserMovementAssetsTest extends TestCase
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
    public function it_gets_user_movement_assets()
    {
        $user = User::factory()->create();
        $movementAssets = MovementAsset::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.movement-assets.index', $user)
        );

        $response->assertOk()->assertSee($movementAssets[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_user_movement_assets()
    {
        $user = User::factory()->create();
        $data = MovementAsset::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.movement-assets.store', $user),
            $data
        );

        unset($data['store_asset_id']);

        $this->assertDatabaseHas('movement_assets', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $movementAsset = MovementAsset::latest('id')->first();

        $this->assertEquals($user->id, $movementAsset->user_id);
    }
}
