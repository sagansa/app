<?php

namespace Tests\Feature\Controllers;

use App\Models\Sop;
use App\Models\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SopControllerTest extends TestCase
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
    public function it_displays_index_view_with_sops()
    {
        $sops = Sop::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('sops.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.sops.index')
            ->assertViewHas('sops');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_sop()
    {
        $response = $this->get(route('sops.create'));

        $response->assertOk()->assertViewIs('app.sops.create');
    }

    /**
     * @test
     */
    public function it_stores_the_sop()
    {
        $data = Sop::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('sops.store'), $data);

        $this->assertDatabaseHas('sops', $data);

        $sop = Sop::latest('id')->first();

        $response->assertRedirect(route('sops.edit', $sop));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_sop()
    {
        $sop = Sop::factory()->create();

        $response = $this->get(route('sops.show', $sop));

        $response
            ->assertOk()
            ->assertViewIs('app.sops.show')
            ->assertViewHas('sop');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_sop()
    {
        $sop = Sop::factory()->create();

        $response = $this->get(route('sops.edit', $sop));

        $response
            ->assertOk()
            ->assertViewIs('app.sops.edit')
            ->assertViewHas('sop');
    }

    /**
     * @test
     */
    public function it_updates_the_sop()
    {
        $sop = Sop::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'revision' => $this->faker->randomNumber(0),
            'file' => $this->faker->text(255),
        ];

        $response = $this->put(route('sops.update', $sop), $data);

        $data['id'] = $sop->id;

        $this->assertDatabaseHas('sops', $data);

        $response->assertRedirect(route('sops.edit', $sop));
    }

    /**
     * @test
     */
    public function it_deletes_the_sop()
    {
        $sop = Sop::factory()->create();

        $response = $this->delete(route('sops.destroy', $sop));

        $response->assertRedirect(route('sops.index'));

        $this->assertModelMissing($sop);
    }
}
