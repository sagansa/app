<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\CleanAndNeat;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CleanAndNeatControllerTest extends TestCase
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
    public function it_displays_index_view_with_clean_and_neats()
    {
        $cleanAndNeats = CleanAndNeat::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('clean-and-neats.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.clean_and_neats.index')
            ->assertViewHas('cleanAndNeats');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_clean_and_neat()
    {
        $response = $this->get(route('clean-and-neats.create'));

        $response->assertOk()->assertViewIs('app.clean_and_neats.create');
    }

    /**
     * @test
     */
    public function it_stores_the_clean_and_neat()
    {
        $data = CleanAndNeat::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('clean-and-neats.store'), $data);

        $this->assertDatabaseHas('clean_and_neats', $data);

        $cleanAndNeat = CleanAndNeat::latest('id')->first();

        $response->assertRedirect(route('clean-and-neats.edit', $cleanAndNeat));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_clean_and_neat()
    {
        $cleanAndNeat = CleanAndNeat::factory()->create();

        $response = $this->get(route('clean-and-neats.show', $cleanAndNeat));

        $response
            ->assertOk()
            ->assertViewIs('app.clean_and_neats.show')
            ->assertViewHas('cleanAndNeat');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_clean_and_neat()
    {
        $cleanAndNeat = CleanAndNeat::factory()->create();

        $response = $this->get(route('clean-and-neats.edit', $cleanAndNeat));

        $response
            ->assertOk()
            ->assertViewIs('app.clean_and_neats.edit')
            ->assertViewHas('cleanAndNeat');
    }

    /**
     * @test
     */
    public function it_updates_the_clean_and_neat()
    {
        $cleanAndNeat = CleanAndNeat::factory()->create();

        $user = User::factory()->create();
        $user = User::factory()->create();

        $data = [
            'left_hand' => $this->faker->text(255),
            'right_hand' => $this->faker->text(255),
            'status' => $this->faker->numberBetween(1, 4),
            'notes' => $this->faker->text,
            'created_by_id' => $user->id,
            'approved_by_id' => $user->id,
        ];

        $response = $this->put(
            route('clean-and-neats.update', $cleanAndNeat),
            $data
        );

        $data['id'] = $cleanAndNeat->id;

        $this->assertDatabaseHas('clean_and_neats', $data);

        $response->assertRedirect(route('clean-and-neats.edit', $cleanAndNeat));
    }

    /**
     * @test
     */
    public function it_deletes_the_clean_and_neat()
    {
        $cleanAndNeat = CleanAndNeat::factory()->create();

        $response = $this->delete(
            route('clean-and-neats.destroy', $cleanAndNeat)
        );

        $response->assertRedirect(route('clean-and-neats.index'));

        $this->assertModelMissing($cleanAndNeat);
    }
}
