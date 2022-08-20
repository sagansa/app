<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\FranchiseGroup;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FranchiseGroupTest extends TestCase
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
    public function it_gets_franchise_groups_list()
    {
        $franchiseGroups = FranchiseGroup::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.franchise-groups.index'));

        $response->assertOk()->assertSee($franchiseGroups[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_franchise_group()
    {
        $data = FranchiseGroup::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.franchise-groups.store'), $data);

        $this->assertDatabaseHas('franchise_groups', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_franchise_group()
    {
        $franchiseGroup = FranchiseGroup::factory()->create();

        $user = User::factory()->create();

        $data = [
            'name' => $this->faker->text(50),
            'status' => $this->faker->numberBetween(1, 2),
            'user_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.franchise-groups.update', $franchiseGroup),
            $data
        );

        $data['id'] = $franchiseGroup->id;

        $this->assertDatabaseHas('franchise_groups', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_franchise_group()
    {
        $franchiseGroup = FranchiseGroup::factory()->create();

        $response = $this->deleteJson(
            route('api.franchise-groups.destroy', $franchiseGroup)
        );

        $this->assertModelMissing($franchiseGroup);

        $response->assertNoContent();
    }
}
