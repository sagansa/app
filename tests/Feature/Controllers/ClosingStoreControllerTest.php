<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ClosingStore;

use App\Models\Store;
use App\Models\ShiftStore;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClosingStoreControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_closing_stores()
    {
        $closingStores = ClosingStore::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('closing-stores.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.closing_stores.index')
            ->assertViewHas('closingStores');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_closing_store()
    {
        $response = $this->get(route('closing-stores.create'));

        $response->assertOk()->assertViewIs('app.closing_stores.create');
    }

    /**
     * @test
     */
    public function it_stores_the_closing_store()
    {
        $data = ClosingStore::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('closing-stores.store'), $data);

        $this->assertDatabaseHas('closing_stores', $data);

        $closingStore = ClosingStore::latest('id')->first();

        $response->assertRedirect(route('closing-stores.edit', $closingStore));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_closing_store()
    {
        $closingStore = ClosingStore::factory()->create();

        $response = $this->get(route('closing-stores.show', $closingStore));

        $response
            ->assertOk()
            ->assertViewIs('app.closing_stores.show')
            ->assertViewHas('closingStore');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_closing_store()
    {
        $closingStore = ClosingStore::factory()->create();

        $response = $this->get(route('closing-stores.edit', $closingStore));

        $response
            ->assertOk()
            ->assertViewIs('app.closing_stores.edit')
            ->assertViewHas('closingStore');
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

        $response = $this->put(
            route('closing-stores.update', $closingStore),
            $data
        );

        $data['id'] = $closingStore->id;

        $this->assertDatabaseHas('closing_stores', $data);

        $response->assertRedirect(route('closing-stores.edit', $closingStore));
    }

    /**
     * @test
     */
    public function it_deletes_the_closing_store()
    {
        $closingStore = ClosingStore::factory()->create();

        $response = $this->delete(
            route('closing-stores.destroy', $closingStore)
        );

        $response->assertRedirect(route('closing-stores.index'));

        $this->assertModelMissing($closingStore);
    }
}
