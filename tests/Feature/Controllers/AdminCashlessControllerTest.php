<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\AdminCashless;

use App\Models\CashlessProvider;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminCashlessControllerTest extends TestCase
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
    public function it_displays_index_view_with_admin_cashlesses()
    {
        $adminCashlesses = AdminCashless::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('admin-cashlesses.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.admin_cashlesses.index')
            ->assertViewHas('adminCashlesses');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_admin_cashless()
    {
        $response = $this->get(route('admin-cashlesses.create'));

        $response->assertOk()->assertViewIs('app.admin_cashlesses.create');
    }

    /**
     * @test
     */
    public function it_stores_the_admin_cashless()
    {
        $data = AdminCashless::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('admin-cashlesses.store'), $data);

        $this->assertDatabaseHas('admin_cashlesses', $data);

        $adminCashless = AdminCashless::latest('id')->first();

        $response->assertRedirect(
            route('admin-cashlesses.edit', $adminCashless)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_admin_cashless()
    {
        $adminCashless = AdminCashless::factory()->create();

        $response = $this->get(route('admin-cashlesses.show', $adminCashless));

        $response
            ->assertOk()
            ->assertViewIs('app.admin_cashlesses.show')
            ->assertViewHas('adminCashless');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_admin_cashless()
    {
        $adminCashless = AdminCashless::factory()->create();

        $response = $this->get(route('admin-cashlesses.edit', $adminCashless));

        $response
            ->assertOk()
            ->assertViewIs('app.admin_cashlesses.edit')
            ->assertViewHas('adminCashless');
    }

    /**
     * @test
     */
    public function it_updates_the_admin_cashless()
    {
        $adminCashless = AdminCashless::factory()->create();

        $cashlessProvider = CashlessProvider::factory()->create();

        $data = [
            'username' => $this->faker->text(50),
            'email' => $this->faker->email,
            'no_telp' => $this->faker->randomNumber,
            'cashless_provider_id' => $cashlessProvider->id,
        ];

        $response = $this->put(
            route('admin-cashlesses.update', $adminCashless),
            $data
        );

        $data['id'] = $adminCashless->id;

        $this->assertDatabaseHas('admin_cashlesses', $data);

        $response->assertRedirect(
            route('admin-cashlesses.edit', $adminCashless)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_admin_cashless()
    {
        $adminCashless = AdminCashless::factory()->create();

        $response = $this->delete(
            route('admin-cashlesses.destroy', $adminCashless)
        );

        $response->assertRedirect(route('admin-cashlesses.index'));

        $this->assertModelMissing($adminCashless);
    }
}
