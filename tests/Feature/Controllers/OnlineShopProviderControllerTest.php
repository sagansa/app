<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\OnlineShopProvider;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OnlineShopProviderControllerTest extends TestCase
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
    public function it_displays_index_view_with_online_shop_providers()
    {
        $onlineShopProviders = OnlineShopProvider::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('online-shop-providers.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.online_shop_providers.index')
            ->assertViewHas('onlineShopProviders');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_online_shop_provider()
    {
        $response = $this->get(route('online-shop-providers.create'));

        $response->assertOk()->assertViewIs('app.online_shop_providers.create');
    }

    /**
     * @test
     */
    public function it_stores_the_online_shop_provider()
    {
        $data = OnlineShopProvider::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('online-shop-providers.store'), $data);

        $this->assertDatabaseHas('online_shop_providers', $data);

        $onlineShopProvider = OnlineShopProvider::latest('id')->first();

        $response->assertRedirect(
            route('online-shop-providers.edit', $onlineShopProvider)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_online_shop_provider()
    {
        $onlineShopProvider = OnlineShopProvider::factory()->create();

        $response = $this->get(
            route('online-shop-providers.show', $onlineShopProvider)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.online_shop_providers.show')
            ->assertViewHas('onlineShopProvider');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_online_shop_provider()
    {
        $onlineShopProvider = OnlineShopProvider::factory()->create();

        $response = $this->get(
            route('online-shop-providers.edit', $onlineShopProvider)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.online_shop_providers.edit')
            ->assertViewHas('onlineShopProvider');
    }

    /**
     * @test
     */
    public function it_updates_the_online_shop_provider()
    {
        $onlineShopProvider = OnlineShopProvider::factory()->create();

        $data = [
            'name' => $this->faker->unique->text(20),
        ];

        $response = $this->put(
            route('online-shop-providers.update', $onlineShopProvider),
            $data
        );

        $data['id'] = $onlineShopProvider->id;

        $this->assertDatabaseHas('online_shop_providers', $data);

        $response->assertRedirect(
            route('online-shop-providers.edit', $onlineShopProvider)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_online_shop_provider()
    {
        $onlineShopProvider = OnlineShopProvider::factory()->create();

        $response = $this->delete(
            route('online-shop-providers.destroy', $onlineShopProvider)
        );

        $response->assertRedirect(route('online-shop-providers.index'));

        $this->assertModelMissing($onlineShopProvider);
    }
}
