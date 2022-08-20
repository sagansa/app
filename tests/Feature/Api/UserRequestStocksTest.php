<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\RequestStock;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRequestStocksTest extends TestCase
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
    public function it_gets_user_request_stocks()
    {
        $user = User::factory()->create();
        $requestStocks = RequestStock::factory()
            ->count(2)
            ->create([
                'approved_by_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.request-stocks.index', $user)
        );

        $response->assertOk()->assertSee($requestStocks[0]->notes);
    }

    /**
     * @test
     */
    public function it_stores_the_user_request_stocks()
    {
        $user = User::factory()->create();
        $data = RequestStock::factory()
            ->make([
                'approved_by_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.request-stocks.store', $user),
            $data
        );

        $this->assertDatabaseHas('request_stocks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $requestStock = RequestStock::latest('id')->first();

        $this->assertEquals($user->id, $requestStock->approved_by_id);
    }
}
