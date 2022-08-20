<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\MaterialGroup;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MaterialGroupControllerTest extends TestCase
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
    public function it_displays_index_view_with_material_groups()
    {
        $materialGroups = MaterialGroup::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('material-groups.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.material_groups.index')
            ->assertViewHas('materialGroups');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_material_group()
    {
        $response = $this->get(route('material-groups.create'));

        $response->assertOk()->assertViewIs('app.material_groups.create');
    }

    /**
     * @test
     */
    public function it_stores_the_material_group()
    {
        $data = MaterialGroup::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('material-groups.store'), $data);

        $this->assertDatabaseHas('material_groups', $data);

        $materialGroup = MaterialGroup::latest('id')->first();

        $response->assertRedirect(
            route('material-groups.edit', $materialGroup)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_material_group()
    {
        $materialGroup = MaterialGroup::factory()->create();

        $response = $this->get(route('material-groups.show', $materialGroup));

        $response
            ->assertOk()
            ->assertViewIs('app.material_groups.show')
            ->assertViewHas('materialGroup');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_material_group()
    {
        $materialGroup = MaterialGroup::factory()->create();

        $response = $this->get(route('material-groups.edit', $materialGroup));

        $response
            ->assertOk()
            ->assertViewIs('app.material_groups.edit')
            ->assertViewHas('materialGroup');
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

        $response = $this->put(
            route('material-groups.update', $materialGroup),
            $data
        );

        $data['id'] = $materialGroup->id;

        $this->assertDatabaseHas('material_groups', $data);

        $response->assertRedirect(
            route('material-groups.edit', $materialGroup)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_material_group()
    {
        $materialGroup = MaterialGroup::factory()->create();

        $response = $this->delete(
            route('material-groups.destroy', $materialGroup)
        );

        $response->assertRedirect(route('material-groups.index'));

        $this->assertModelMissing($materialGroup);
    }
}
