<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\MaterialGroup;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MaterialGroupTest extends TestCase
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
    public function it_gets_material_groups_list()
    {
        $materialGroups = MaterialGroup::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.material-groups.index'));

        $response->assertOk()->assertSee($materialGroups[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_material_group()
    {
        $data = MaterialGroup::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.material-groups.store'), $data);

        $this->assertDatabaseHas('material_groups', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_material_group()
    {
        $materialGroup = MaterialGroup::factory()->create();

        $user = User::factory()->create();

        $data = [
            'name' => $this->faker->text(50),
            'status' => $this->faker->numberBetween(1, 2),
            'user_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.material-groups.update', $materialGroup),
            $data
        );

        $data['id'] = $materialGroup->id;

        $this->assertDatabaseHas('material_groups', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_material_group()
    {
        $materialGroup = MaterialGroup::factory()->create();

        $response = $this->deleteJson(
            route('api.material-groups.destroy', $materialGroup)
        );

        $this->assertModelMissing($materialGroup);

        $response->assertNoContent();
    }
}
