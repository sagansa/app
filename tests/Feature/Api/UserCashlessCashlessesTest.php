<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Cashless;
use App\Models\UserCashless;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserCashlessCashlessesTest extends TestCase
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
    public function it_gets_user_cashless_cashlesses()
    {
        $userCashless = UserCashless::factory()->create();
        $cashlesses = Cashless::factory()
            ->count(2)
            ->create([
                'user_cashless_id' => $userCashless->id,
            ]);

        $response = $this->getJson(
            route('api.user-cashlesses.cashlesses.index', $userCashless)
        );

        $response->assertOk()->assertSee($cashlesses[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_user_cashless_cashlesses()
    {
        $userCashless = UserCashless::factory()->create();
        $data = Cashless::factory()
            ->make([
                'user_cashless_id' => $userCashless->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.user-cashlesses.cashlesses.store', $userCashless),
            $data
        );

        unset($data['closing_store_id']);

        $this->assertDatabaseHas('cashlesses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $cashless = Cashless::latest('id')->first();

        $this->assertEquals($userCashless->id, $cashless->user_cashless_id);
    }
}
