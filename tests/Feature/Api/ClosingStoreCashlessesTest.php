<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Cashless;
use App\Models\ClosingStore;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClosingStoreCashlessesTest extends TestCase
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
    public function it_gets_closing_store_cashlesses()
    {
        $closingStore = ClosingStore::factory()->create();
        $cashlesses = Cashless::factory()
            ->count(2)
            ->create([
                'closing_store_id' => $closingStore->id,
            ]);

        $response = $this->getJson(
            route('api.closing-stores.cashlesses.index', $closingStore)
        );

        $response->assertOk()->assertSee($cashlesses[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_closing_store_cashlesses()
    {
        $closingStore = ClosingStore::factory()->create();
        $data = Cashless::factory()
            ->make([
                'closing_store_id' => $closingStore->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.closing-stores.cashlesses.store', $closingStore),
            $data
        );

        unset($data['closing_store_id']);

        $this->assertDatabaseHas('cashlesses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $cashless = Cashless::latest('id')->first();

        $this->assertEquals($closingStore->id, $cashless->closing_store_id);
    }
}
