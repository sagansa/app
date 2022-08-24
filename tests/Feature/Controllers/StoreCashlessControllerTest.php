<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\StoreCashless;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreCashlessControllerTest extends TestCase
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
    public function it_displays_index_view_with_store_cashlesses()
    {
        $storeCashlesses = StoreCashless::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('store-cashlesses.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.store_cashlesses.index')
            ->assertViewHas('storeCashlesses');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_store_cashless()
    {
        $response = $this->get(route('store-cashlesses.create'));

        $response->assertOk()->assertViewIs('app.store_cashlesses.create');
    }

    /**
     * @test
     */
    public function it_stores_the_store_cashless()
    {
        $data = StoreCashless::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('store-cashlesses.store'), $data);

        $this->assertDatabaseHas('store_cashlesses', $data);

        $storeCashless = StoreCashless::latest('id')->first();

        $response->assertRedirect(
            route('store-cashlesses.edit', $storeCashless)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_store_cashless()
    {
        $storeCashless = StoreCashless::factory()->create();

        $response = $this->get(route('store-cashlesses.show', $storeCashless));

        $response
            ->assertOk()
            ->assertViewIs('app.store_cashlesses.show')
            ->assertViewHas('storeCashless');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_store_cashless()
    {
        $storeCashless = StoreCashless::factory()->create();

        $response = $this->get(route('store-cashlesses.edit', $storeCashless));

        $response
            ->assertOk()
            ->assertViewIs('app.store_cashlesses.edit')
            ->assertViewHas('storeCashless');
    }

    /**
     * @test
     */
    public function it_updates_the_store_cashless()
    {
        $storeCashless = StoreCashless::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'status' => $this->faker->numberBetween(1, 2),
        ];

        $response = $this->put(
            route('store-cashlesses.update', $storeCashless),
            $data
        );

        $data['id'] = $storeCashless->id;

        $this->assertDatabaseHas('store_cashlesses', $data);

        $response->assertRedirect(
            route('store-cashlesses.edit', $storeCashless)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_store_cashless()
    {
        $storeCashless = StoreCashless::factory()->create();

        $response = $this->delete(
            route('store-cashlesses.destroy', $storeCashless)
        );

        $response->assertRedirect(route('store-cashlesses.index'));

        $this->assertModelMissing($storeCashless);
    }
}
