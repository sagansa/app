<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Cashless;
use App\Models\AccountCashless;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountCashlessCashlessesTest extends TestCase
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
    public function it_gets_account_cashless_cashlesses()
    {
        $accountCashless = AccountCashless::factory()->create();
        $cashlesses = Cashless::factory()
            ->count(2)
            ->create([
                'account_cashless_id' => $accountCashless->id,
            ]);

        $response = $this->getJson(
            route('api.account-cashlesses.cashlesses.index', $accountCashless)
        );

        $response->assertOk()->assertSee($cashlesses[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_account_cashless_cashlesses()
    {
        $accountCashless = AccountCashless::factory()->create();
        $data = Cashless::factory()
            ->make([
                'account_cashless_id' => $accountCashless->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.account-cashlesses.cashlesses.store', $accountCashless),
            $data
        );

        unset($data['closing_store_id']);

        $this->assertDatabaseHas('cashlesses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $cashless = Cashless::latest('id')->first();

        $this->assertEquals(
            $accountCashless->id,
            $cashless->account_cashless_id
        );
    }
}
