<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\OnlineShopProvider;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OnlineShopProviderTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_online_shop_providers_list()
    {
        $onlineShopProviders = OnlineShopProvider::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.online-shop-providers.index'));

        $response->assertOk()->assertSee($onlineShopProviders[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_online_shop_provider()
    {
        $data = OnlineShopProvider::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.online-shop-providers.store'),
            $data
        );

        $this->assertDatabaseHas('online_shop_providers', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.online-shop-providers.update', $onlineShopProvider),
            $data
        );

        $data['id'] = $onlineShopProvider->id;

        $this->assertDatabaseHas('online_shop_providers', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_online_shop_provider()
    {
        $onlineShopProvider = OnlineShopProvider::factory()->create();

        $response = $this->deleteJson(
            route('api.online-shop-providers.destroy', $onlineShopProvider)
        );

        $this->assertModelMissing($onlineShopProvider);

        $response->assertNoContent();
    }
}
