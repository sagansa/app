<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Store;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreControllerTest extends TestCase
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
    public function it_displays_index_view_with_stores()
    {
        $stores = Store::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('stores.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.stores.index')
            ->assertViewHas('stores');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_store()
    {
        $response = $this->get(route('stores.create'));

        $response->assertOk()->assertViewIs('app.stores.create');
    }

    /**
     * @test
     */
    public function it_stores_the_store()
    {
        $data = Store::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('stores.store'), $data);

        unset($data['user_id']);

        $this->assertDatabaseHas('stores', $data);

        $store = Store::latest('id')->first();

        $response->assertRedirect(route('stores.edit', $store));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_store()
    {
        $store = Store::factory()->create();

        $response = $this->get(route('stores.show', $store));

        $response
            ->assertOk()
            ->assertViewIs('app.stores.show')
            ->assertViewHas('store');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_store()
    {
        $store = Store::factory()->create();

        $response = $this->get(route('stores.edit', $store));

        $response
            ->assertOk()
            ->assertViewIs('app.stores.edit')
            ->assertViewHas('store');
    }

    /**
     * @test
     */
    public function it_updates_the_store()
    {
        $store = Store::factory()->create();

        $user = User::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'nickname' => $this->faker->userName,
            'no_telp' => $this->faker->phoneNumber,
            'email' => $this->faker->unique->email,
            'status' => $this->faker->numberBetween(1, 4),
            'user_id' => $user->id,
        ];

        $response = $this->put(route('stores.update', $store), $data);

        unset($data['user_id']);

        $data['id'] = $store->id;

        $this->assertDatabaseHas('stores', $data);

        $response->assertRedirect(route('stores.edit', $store));
    }

    /**
     * @test
     */
    public function it_deletes_the_store()
    {
        $store = Store::factory()->create();

        $response = $this->delete(route('stores.destroy', $store));

        $response->assertRedirect(route('stores.index'));

        $this->assertModelMissing($store);
    }
}
