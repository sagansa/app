<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ClosingStore;

use App\Models\Store;
use App\Models\ShiftStore;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClosingStoreTest extends TestCase
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
    public function it_gets_closing_stores_list()
    {
        $closingStores = ClosingStore::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.closing-stores.index'));

        $response->assertOk()->assertSee($closingStores[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_closing_store()
    {
        $data = ClosingStore::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.closing-stores.store'), $data);

        $this->assertDatabaseHas('closing_stores', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_closing_store()
    {
        $closingStore = ClosingStore::factory()->create();

        $store = Store::factory()->create();
        $shiftStore = ShiftStore::factory()->create();
        $user = User::factory()->create();
        $user = User::factory()->create();
        $user = User::factory()->create();

        $data = [
            'date' => $this->faker->date,
            'cash_from_yesterday' => $this->faker->randomNumber,
            'cash_for_tomorrow' => $this->faker->randomNumber,
            'total_cash_transfer' => $this->faker->randomNumber,
            'status' => $this->faker->numberBetween(1, 4),
            'notes' => $this->faker->text,
            'store_id' => $store->id,
            'shift_store_id' => $shiftStore->id,
            'transfer_by_id' => $user->id,
            'created_by_id' => $user->id,
            'approved_by_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.closing-stores.update', $closingStore),
            $data
        );

        $data['id'] = $closingStore->id;

        $this->assertDatabaseHas('closing_stores', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_closing_store()
    {
        $closingStore = ClosingStore::factory()->create();

        $response = $this->deleteJson(
            route('api.closing-stores.destroy', $closingStore)
        );

        $this->assertModelMissing($closingStore);

        $response->assertNoContent();
    }
}
