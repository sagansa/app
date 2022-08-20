<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\FranchiseGroup;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserFranchiseGroupsTest extends TestCase
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
    public function it_gets_user_franchise_groups()
    {
        $user = User::factory()->create();
        $franchiseGroups = FranchiseGroup::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.franchise-groups.index', $user)
        );

        $response->assertOk()->assertSee($franchiseGroups[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_user_franchise_groups()
    {
        $user = User::factory()->create();
        $data = FranchiseGroup::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.franchise-groups.store', $user),
            $data
        );

        $this->assertDatabaseHas('franchise_groups', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $franchiseGroup = FranchiseGroup::latest('id')->first();

        $this->assertEquals($user->id, $franchiseGroup->user_id);
    }
}
