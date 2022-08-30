<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\UtilityUsage;

use App\Models\Utility;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UtilityUsageControllerTest extends TestCase
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
    public function it_displays_index_view_with_utility_usages()
    {
        $utilityUsages = UtilityUsage::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('utility-usages.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.utility_usages.index')
            ->assertViewHas('utilityUsages');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_utility_usage()
    {
        $response = $this->get(route('utility-usages.create'));

        $response->assertOk()->assertViewIs('app.utility_usages.create');
    }

    /**
     * @test
     */
    public function it_stores_the_utility_usage()
    {
        $data = UtilityUsage::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('utility-usages.store'), $data);

        $this->assertDatabaseHas('utility_usages', $data);

        $utilityUsage = UtilityUsage::latest('id')->first();

        $response->assertRedirect(route('utility-usages.edit', $utilityUsage));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_utility_usage()
    {
        $utilityUsage = UtilityUsage::factory()->create();

        $response = $this->get(route('utility-usages.show', $utilityUsage));

        $response
            ->assertOk()
            ->assertViewIs('app.utility_usages.show')
            ->assertViewHas('utilityUsage');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_utility_usage()
    {
        $utilityUsage = UtilityUsage::factory()->create();

        $response = $this->get(route('utility-usages.edit', $utilityUsage));

        $response
            ->assertOk()
            ->assertViewIs('app.utility_usages.edit')
            ->assertViewHas('utilityUsage');
    }

    /**
     * @test
     */
    public function it_updates_the_utility_usage()
    {
        $utilityUsage = UtilityUsage::factory()->create();

        $user = User::factory()->create();
        $user = User::factory()->create();
        $utility = Utility::factory()->create();

        $data = [
            'result' => $this->faker->randomNumber(2),
            'status' => $this->faker->numberBetween(1, 4),
            'notes' => $this->faker->text,
            'created_by_id' => $user->id,
            'approved_by_id' => $user->id,
            'utility_id' => $utility->id,
        ];

        $response = $this->put(
            route('utility-usages.update', $utilityUsage),
            $data
        );

        $data['id'] = $utilityUsage->id;

        $this->assertDatabaseHas('utility_usages', $data);

        $response->assertRedirect(route('utility-usages.edit', $utilityUsage));
    }

    /**
     * @test
     */
    public function it_deletes_the_utility_usage()
    {
        $utilityUsage = UtilityUsage::factory()->create();

        $response = $this->delete(
            route('utility-usages.destroy', $utilityUsage)
        );

        $response->assertRedirect(route('utility-usages.index'));

        $this->assertModelMissing($utilityUsage);
    }
}
