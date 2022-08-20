<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ShiftStore;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShiftStoreControllerTest extends TestCase
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
    public function it_displays_index_view_with_shift_stores()
    {
        $shiftStores = ShiftStore::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('shift-stores.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.shift_stores.index')
            ->assertViewHas('shiftStores');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_shift_store()
    {
        $response = $this->get(route('shift-stores.create'));

        $response->assertOk()->assertViewIs('app.shift_stores.create');
    }

    /**
     * @test
     */
    public function it_stores_the_shift_store()
    {
        $data = ShiftStore::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('shift-stores.store'), $data);

        $this->assertDatabaseHas('shift_stores', $data);

        $shiftStore = ShiftStore::latest('id')->first();

        $response->assertRedirect(route('shift-stores.edit', $shiftStore));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_shift_store()
    {
        $shiftStore = ShiftStore::factory()->create();

        $response = $this->get(route('shift-stores.show', $shiftStore));

        $response
            ->assertOk()
            ->assertViewIs('app.shift_stores.show')
            ->assertViewHas('shiftStore');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_shift_store()
    {
        $shiftStore = ShiftStore::factory()->create();

        $response = $this->get(route('shift-stores.edit', $shiftStore));

        $response
            ->assertOk()
            ->assertViewIs('app.shift_stores.edit')
            ->assertViewHas('shiftStore');
    }

    /**
     * @test
     */
    public function it_updates_the_shift_store()
    {
        $shiftStore = ShiftStore::factory()->create();

        $data = [
            'name' => $this->faker->unique->text(50),
        ];

        $response = $this->put(
            route('shift-stores.update', $shiftStore),
            $data
        );

        $data['id'] = $shiftStore->id;

        $this->assertDatabaseHas('shift_stores', $data);

        $response->assertRedirect(route('shift-stores.edit', $shiftStore));
    }

    /**
     * @test
     */
    public function it_deletes_the_shift_store()
    {
        $shiftStore = ShiftStore::factory()->create();

        $response = $this->delete(route('shift-stores.destroy', $shiftStore));

        $response->assertRedirect(route('shift-stores.index'));

        $this->assertModelMissing($shiftStore);
    }
}
