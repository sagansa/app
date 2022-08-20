<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\RemainingStock;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRemainingStocksTest extends TestCase
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
    public function it_gets_user_remaining_stocks()
    {
        $user = User::factory()->create();
        $remainingStocks = RemainingStock::factory()
            ->count(2)
            ->create([
                'approved_by_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.remaining-stocks.index', $user)
        );

        $response->assertOk()->assertSee($remainingStocks[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_user_remaining_stocks()
    {
        $user = User::factory()->create();
        $data = RemainingStock::factory()
            ->make([
                'approved_by_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.remaining-stocks.store', $user),
            $data
        );

        $this->assertDatabaseHas('remaining_stocks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $remainingStock = RemainingStock::latest('id')->first();

        $this->assertEquals($user->id, $remainingStock->approved_by_id);
    }
}
