<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ShiftStore;
use App\Models\ClosingStore;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShiftStoreClosingStoresTest extends TestCase
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
    public function it_gets_shift_store_closing_stores()
    {
        $shiftStore = ShiftStore::factory()->create();
        $closingStores = ClosingStore::factory()
            ->count(2)
            ->create([
                'shift_store_id' => $shiftStore->id,
            ]);

        $response = $this->getJson(
            route('api.shift-stores.closing-stores.index', $shiftStore)
        );

        $response->assertOk()->assertSee($closingStores[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_shift_store_closing_stores()
    {
        $shiftStore = ShiftStore::factory()->create();
        $data = ClosingStore::factory()
            ->make([
                'shift_store_id' => $shiftStore->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.shift-stores.closing-stores.store', $shiftStore),
            $data
        );

        $this->assertDatabaseHas('closing_stores', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $closingStore = ClosingStore::latest('id')->first();

        $this->assertEquals($shiftStore->id, $closingStore->shift_store_id);
    }
}
