<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\UserCashless;

use App\Models\Store;
use App\Models\StoreCashless;
use App\Models\CashlessProvider;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserCashlessControllerTest extends TestCase
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
    public function it_displays_index_view_with_user_cashlesses()
    {
        $userCashlesses = UserCashless::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('user-cashlesses.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.user_cashlesses.index')
            ->assertViewHas('userCashlesses');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_user_cashless()
    {
        $response = $this->get(route('user-cashlesses.create'));

        $response->assertOk()->assertViewIs('app.user_cashlesses.create');
    }

    /**
     * @test
     */
    public function it_stores_the_user_cashless()
    {
        $data = UserCashless::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('user-cashlesses.store'), $data);

        $this->assertDatabaseHas('user_cashlesses', $data);

        $userCashless = UserCashless::latest('id')->first();

        $response->assertRedirect(route('user-cashlesses.edit', $userCashless));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_user_cashless()
    {
        $userCashless = UserCashless::factory()->create();

        $response = $this->get(route('user-cashlesses.show', $userCashless));

        $response
            ->assertOk()
            ->assertViewIs('app.user_cashlesses.show')
            ->assertViewHas('userCashless');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_user_cashless()
    {
        $userCashless = UserCashless::factory()->create();

        $response = $this->get(route('user-cashlesses.edit', $userCashless));

        $response
            ->assertOk()
            ->assertViewIs('app.user_cashlesses.edit')
            ->assertViewHas('userCashless');
    }

    /**
     * @test
     */
    public function it_updates_the_user_cashless()
    {
        $userCashless = UserCashless::factory()->create();

        $store = Store::factory()->create();
        $storeCashless = StoreCashless::factory()->create();
        $cashlessProvider = CashlessProvider::factory()->create();

        $data = [
            'email' => $this->faker->email,
            'username' => $this->faker->text(50),
            'no_telp' => $this->faker->randomNumber,
            'status' => $this->faker->numberBetween(1, 2),
            'store_id' => $store->id,
            'store_cashless_id' => $storeCashless->id,
            'cashless_provider_id' => $cashlessProvider->id,
        ];

        $response = $this->put(
            route('user-cashlesses.update', $userCashless),
            $data
        );

        $data['id'] = $userCashless->id;

        $this->assertDatabaseHas('user_cashlesses', $data);

        $response->assertRedirect(route('user-cashlesses.edit', $userCashless));
    }

    /**
     * @test
     */
    public function it_deletes_the_user_cashless()
    {
        $userCashless = UserCashless::factory()->create();

        $response = $this->delete(
            route('user-cashlesses.destroy', $userCashless)
        );

        $response->assertRedirect(route('user-cashlesses.index'));

        $this->assertModelMissing($userCashless);
    }
}
