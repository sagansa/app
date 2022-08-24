<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\AccountCashless;

use App\Models\Store;
use App\Models\StoreCashless;
use App\Models\CashlessProvider;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountCashlessControllerTest extends TestCase
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
    public function it_displays_index_view_with_account_cashlesses()
    {
        $accountCashlesses = AccountCashless::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('account-cashlesses.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.account_cashlesses.index')
            ->assertViewHas('accountCashlesses');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_account_cashless()
    {
        $response = $this->get(route('account-cashlesses.create'));

        $response->assertOk()->assertViewIs('app.account_cashlesses.create');
    }

    /**
     * @test
     */
    public function it_stores_the_account_cashless()
    {
        $data = AccountCashless::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('account-cashlesses.store'), $data);

        $this->assertDatabaseHas('account_cashlesses', $data);

        $accountCashless = AccountCashless::latest('id')->first();

        $response->assertRedirect(
            route('account-cashlesses.edit', $accountCashless)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_account_cashless()
    {
        $accountCashless = AccountCashless::factory()->create();

        $response = $this->get(
            route('account-cashlesses.show', $accountCashless)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.account_cashlesses.show')
            ->assertViewHas('accountCashless');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_account_cashless()
    {
        $accountCashless = AccountCashless::factory()->create();

        $response = $this->get(
            route('account-cashlesses.edit', $accountCashless)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.account_cashlesses.edit')
            ->assertViewHas('accountCashless');
    }

    /**
     * @test
     */
    public function it_updates_the_account_cashless()
    {
        $accountCashless = AccountCashless::factory()->create();

        $cashlessProvider = CashlessProvider::factory()->create();
        $store = Store::factory()->create();
        $storeCashless = StoreCashless::factory()->create();

        $data = [
            'email' => $this->faker->email,
            'username' => $this->faker->text(255),
            'no_telp' => $this->faker->randomNumber,
            'status' => $this->faker->numberBetween(1, 2),
            'notes' => $this->faker->text,
            'cashless_provider_id' => $cashlessProvider->id,
            'store_id' => $store->id,
            'store_cashless_id' => $storeCashless->id,
        ];

        $response = $this->put(
            route('account-cashlesses.update', $accountCashless),
            $data
        );

        $data['id'] = $accountCashless->id;

        $this->assertDatabaseHas('account_cashlesses', $data);

        $response->assertRedirect(
            route('account-cashlesses.edit', $accountCashless)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_account_cashless()
    {
        $accountCashless = AccountCashless::factory()->create();

        $response = $this->delete(
            route('account-cashlesses.destroy', $accountCashless)
        );

        $response->assertRedirect(route('account-cashlesses.index'));

        $this->assertModelMissing($accountCashless);
    }
}
