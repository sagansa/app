<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\CashlessProvider;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CashlessProviderTest extends TestCase
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
    public function it_gets_cashless_providers_list()
    {
        $cashlessProviders = CashlessProvider::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.cashless-providers.index'));

        $response->assertOk()->assertSee($cashlessProviders[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_cashless_provider()
    {
        $data = CashlessProvider::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.cashless-providers.store'),
            $data
        );

        $this->assertDatabaseHas('cashless_providers', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_cashless_provider()
    {
        $cashlessProvider = CashlessProvider::factory()->create();

        $data = [
            'name' => $this->faker->unique->text(50),
        ];

        $response = $this->putJson(
            route('api.cashless-providers.update', $cashlessProvider),
            $data
        );

        $data['id'] = $cashlessProvider->id;

        $this->assertDatabaseHas('cashless_providers', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_cashless_provider()
    {
        $cashlessProvider = CashlessProvider::factory()->create();

        $response = $this->deleteJson(
            route('api.cashless-providers.destroy', $cashlessProvider)
        );

        $this->assertModelMissing($cashlessProvider);

        $response->assertNoContent();
    }
}
