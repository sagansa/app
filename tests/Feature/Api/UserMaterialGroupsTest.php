<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\MaterialGroup;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserMaterialGroupsTest extends TestCase
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
    public function it_gets_user_material_groups()
    {
        $user = User::factory()->create();
        $materialGroups = MaterialGroup::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.material-groups.index', $user)
        );

        $response->assertOk()->assertSee($materialGroups[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_user_material_groups()
    {
        $user = User::factory()->create();
        $data = MaterialGroup::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.material-groups.store', $user),
            $data
        );

        $this->assertDatabaseHas('material_groups', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $materialGroup = MaterialGroup::latest('id')->first();

        $this->assertEquals($user->id, $materialGroup->user_id);
    }
}
