<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\TransferStock;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTransferStocksTest extends TestCase
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
    public function it_gets_user_transfer_stocks()
    {
        $user = User::factory()->create();
        $transferStocks = TransferStock::factory()
            ->count(2)
            ->create([
                'sent_by_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.transfer-stocks.index', $user)
        );

        $response->assertOk()->assertSee($transferStocks[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_user_transfer_stocks()
    {
        $user = User::factory()->create();
        $data = TransferStock::factory()
            ->make([
                'sent_by_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.transfer-stocks.store', $user),
            $data
        );

        unset($data['image']);

        $this->assertDatabaseHas('transfer_stocks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $transferStock = TransferStock::latest('id')->first();

        $this->assertEquals($user->id, $transferStock->sent_by_id);
    }
}
