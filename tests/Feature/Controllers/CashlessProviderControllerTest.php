<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\CashlessProvider;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CashlessProviderControllerTest extends TestCase
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
    public function it_displays_index_view_with_cashless_providers()
    {
        $cashlessProviders = CashlessProvider::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('cashless-providers.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.cashless_providers.index')
            ->assertViewHas('cashlessProviders');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_cashless_provider()
    {
        $response = $this->get(route('cashless-providers.create'));

        $response->assertOk()->assertViewIs('app.cashless_providers.create');
    }

    /**
     * @test
     */
    public function it_stores_the_cashless_provider()
    {
        $data = CashlessProvider::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('cashless-providers.store'), $data);

        $this->assertDatabaseHas('cashless_providers', $data);

        $cashlessProvider = CashlessProvider::latest('id')->first();

        $response->assertRedirect(
            route('cashless-providers.edit', $cashlessProvider)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_cashless_provider()
    {
        $cashlessProvider = CashlessProvider::factory()->create();

        $response = $this->get(
            route('cashless-providers.show', $cashlessProvider)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.cashless_providers.show')
            ->assertViewHas('cashlessProvider');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_cashless_provider()
    {
        $cashlessProvider = CashlessProvider::factory()->create();

        $response = $this->get(
            route('cashless-providers.edit', $cashlessProvider)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.cashless_providers.edit')
            ->assertViewHas('cashlessProvider');
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

        $response = $this->put(
            route('cashless-providers.update', $cashlessProvider),
            $data
        );

        $data['id'] = $cashlessProvider->id;

        $this->assertDatabaseHas('cashless_providers', $data);

        $response->assertRedirect(
            route('cashless-providers.edit', $cashlessProvider)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_cashless_provider()
    {
        $cashlessProvider = CashlessProvider::factory()->create();

        $response = $this->delete(
            route('cashless-providers.destroy', $cashlessProvider)
        );

        $response->assertRedirect(route('cashless-providers.index'));

        $this->assertModelMissing($cashlessProvider);
    }
}
