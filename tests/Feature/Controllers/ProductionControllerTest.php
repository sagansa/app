<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Production;

use App\Models\Store;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductionControllerTest extends TestCase
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
    public function it_displays_index_view_with_productions()
    {
        $productions = Production::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('productions.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.productions.index')
            ->assertViewHas('productions');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_production()
    {
        $response = $this->get(route('productions.create'));

        $response->assertOk()->assertViewIs('app.productions.create');
    }

    /**
     * @test
     */
    public function it_stores_the_production()
    {
        $data = Production::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('productions.store'), $data);

        $this->assertDatabaseHas('productions', $data);

        $production = Production::latest('id')->first();

        $response->assertRedirect(route('productions.edit', $production));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_production()
    {
        $production = Production::factory()->create();

        $response = $this->get(route('productions.show', $production));

        $response
            ->assertOk()
            ->assertViewIs('app.productions.show')
            ->assertViewHas('production');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_production()
    {
        $production = Production::factory()->create();

        $response = $this->get(route('productions.edit', $production));

        $response
            ->assertOk()
            ->assertViewIs('app.productions.edit')
            ->assertViewHas('production');
    }

    /**
     * @test
     */
    public function it_updates_the_production()
    {
        $production = Production::factory()->create();

        $store = Store::factory()->create();
        $user = User::factory()->create();
        $user = User::factory()->create();

        $data = [
            'date' => $this->faker->date,
            'status' => $this->faker->numberBetween(1, 4),
            'notes' => $this->faker->text,
            'store_id' => $store->id,
            'created_by_id' => $user->id,
            'approved_by_id' => $user->id,
        ];

        $response = $this->put(route('productions.update', $production), $data);

        $data['id'] = $production->id;

        $this->assertDatabaseHas('productions', $data);

        $response->assertRedirect(route('productions.edit', $production));
    }

    /**
     * @test
     */
    public function it_deletes_the_production()
    {
        $production = Production::factory()->create();

        $response = $this->delete(route('productions.destroy', $production));

        $response->assertRedirect(route('productions.index'));

        $this->assertModelMissing($production);
    }
}
