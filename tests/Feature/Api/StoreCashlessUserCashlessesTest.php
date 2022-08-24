<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\UserCashless;
use App\Models\StoreCashless;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreCashlessUserCashlessesTest extends TestCase
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
    public function it_gets_store_cashless_user_cashlesses()
    {
        $storeCashless = StoreCashless::factory()->create();
        $userCashlesses = UserCashless::factory()
            ->count(2)
            ->create([
                'store_cashless_id' => $storeCashless->id,
            ]);

        $response = $this->getJson(
            route('api.store-cashlesses.user-cashlesses.index', $storeCashless)
        );

        $response->assertOk()->assertSee($userCashlesses[0]->email);
    }

    /**
     * @test
     */
    public function it_stores_the_store_cashless_user_cashlesses()
    {
        $storeCashless = StoreCashless::factory()->create();
        $data = UserCashless::factory()
            ->make([
                'store_cashless_id' => $storeCashless->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.store-cashlesses.user-cashlesses.store', $storeCashless),
            $data
        );

        $this->assertDatabaseHas('user_cashlesses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $userCashless = UserCashless::latest('id')->first();

        $this->assertEquals(
            $storeCashless->id,
            $userCashless->store_cashless_id
        );
    }
}
