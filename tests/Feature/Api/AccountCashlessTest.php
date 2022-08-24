<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\AccountCashless;

use App\Models\Store;
use App\Models\StoreCashless;
use App\Models\CashlessProvider;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountCashlessTest extends TestCase
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
    public function it_gets_account_cashlesses_list()
    {
        $accountCashlesses = AccountCashless::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.account-cashlesses.index'));

        $response->assertOk()->assertSee($accountCashlesses[0]->email);
    }

    /**
     * @test
     */
    public function it_stores_the_account_cashless()
    {
        $data = AccountCashless::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.account-cashlesses.store'),
            $data
        );

        $this->assertDatabaseHas('account_cashlesses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.account-cashlesses.update', $accountCashless),
            $data
        );

        $data['id'] = $accountCashless->id;

        $this->assertDatabaseHas('account_cashlesses', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_account_cashless()
    {
        $accountCashless = AccountCashless::factory()->create();

        $response = $this->deleteJson(
            route('api.account-cashlesses.destroy', $accountCashless)
        );

        $this->assertModelMissing($accountCashless);

        $response->assertNoContent();
    }
}
