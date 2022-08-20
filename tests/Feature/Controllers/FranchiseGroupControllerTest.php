<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\FranchiseGroup;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FranchiseGroupControllerTest extends TestCase
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
    public function it_displays_index_view_with_franchise_groups()
    {
        $franchiseGroups = FranchiseGroup::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('franchise-groups.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.franchise_groups.index')
            ->assertViewHas('franchiseGroups');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_franchise_group()
    {
        $response = $this->get(route('franchise-groups.create'));

        $response->assertOk()->assertViewIs('app.franchise_groups.create');
    }

    /**
     * @test
     */
    public function it_stores_the_franchise_group()
    {
        $data = FranchiseGroup::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('franchise-groups.store'), $data);

        $this->assertDatabaseHas('franchise_groups', $data);

        $franchiseGroup = FranchiseGroup::latest('id')->first();

        $response->assertRedirect(
            route('franchise-groups.edit', $franchiseGroup)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_franchise_group()
    {
        $franchiseGroup = FranchiseGroup::factory()->create();

        $response = $this->get(route('franchise-groups.show', $franchiseGroup));

        $response
            ->assertOk()
            ->assertViewIs('app.franchise_groups.show')
            ->assertViewHas('franchiseGroup');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_franchise_group()
    {
        $franchiseGroup = FranchiseGroup::factory()->create();

        $response = $this->get(route('franchise-groups.edit', $franchiseGroup));

        $response
            ->assertOk()
            ->assertViewIs('app.franchise_groups.edit')
            ->assertViewHas('franchiseGroup');
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

        $response = $this->put(
            route('franchise-groups.update', $franchiseGroup),
            $data
        );

        $data['id'] = $franchiseGroup->id;

        $this->assertDatabaseHas('franchise_groups', $data);

        $response->assertRedirect(
            route('franchise-groups.edit', $franchiseGroup)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_franchise_group()
    {
        $franchiseGroup = FranchiseGroup::factory()->create();

        $response = $this->delete(
            route('franchise-groups.destroy', $franchiseGroup)
        );

        $response->assertRedirect(route('franchise-groups.index'));

        $this->assertModelMissing($franchiseGroup);
    }
}
