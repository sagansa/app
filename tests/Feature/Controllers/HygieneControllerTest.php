<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Hygiene;

use App\Models\Store;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HygieneControllerTest extends TestCase
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
    public function it_displays_index_view_with_hygienes()
    {
        $hygienes = Hygiene::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('hygienes.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.hygienes.index')
            ->assertViewHas('hygienes');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_hygiene()
    {
        $response = $this->get(route('hygienes.create'));

        $response->assertOk()->assertViewIs('app.hygienes.create');
    }

    /**
     * @test
     */
    public function it_stores_the_hygiene()
    {
        $data = Hygiene::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('hygienes.store'), $data);

        $this->assertDatabaseHas('hygienes', $data);

        $hygiene = Hygiene::latest('id')->first();

        $response->assertRedirect(route('hygienes.edit', $hygiene));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_hygiene()
    {
        $hygiene = Hygiene::factory()->create();

        $response = $this->get(route('hygienes.show', $hygiene));

        $response
            ->assertOk()
            ->assertViewIs('app.hygienes.show')
            ->assertViewHas('hygiene');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_hygiene()
    {
        $hygiene = Hygiene::factory()->create();

        $response = $this->get(route('hygienes.edit', $hygiene));

        $response
            ->assertOk()
            ->assertViewIs('app.hygienes.edit')
            ->assertViewHas('hygiene');
    }

    /**
     * @test
     */
    public function it_updates_the_hygiene()
    {
        $hygiene = Hygiene::factory()->create();

        $store = Store::factory()->create();
        $user = User::factory()->create();
        $user = User::factory()->create();

        $data = [
            'status' => $this->faker->numberBetween(1, 4),
            'notes' => $this->faker->text,
            'store_id' => $store->id,
            'created_by_id' => $user->id,
            'approved_by_id' => $user->id,
        ];

        $response = $this->put(route('hygienes.update', $hygiene), $data);

        $data['id'] = $hygiene->id;

        $this->assertDatabaseHas('hygienes', $data);

        $response->assertRedirect(route('hygienes.edit', $hygiene));
    }

    /**
     * @test
     */
    public function it_deletes_the_hygiene()
    {
        $hygiene = Hygiene::factory()->create();

        $response = $this->delete(route('hygienes.destroy', $hygiene));

        $response->assertRedirect(route('hygienes.index'));

        $this->assertModelMissing($hygiene);
    }
}
