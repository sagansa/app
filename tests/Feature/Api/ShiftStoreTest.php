<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ShiftStore;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShiftStoreTest extends TestCase
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
    public function it_gets_shift_stores_list()
    {
        $shiftStores = ShiftStore::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.shift-stores.index'));

        $response->assertOk()->assertSee($shiftStores[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_shift_store()
    {
        $data = ShiftStore::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.shift-stores.store'), $data);

        $this->assertDatabaseHas('shift_stores', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_shift_store()
    {
        $shiftStore = ShiftStore::factory()->create();

        $data = [
            'name' => $this->faker->unique->text(50),
        ];

        $response = $this->putJson(
            route('api.shift-stores.update', $shiftStore),
            $data
        );

        $data['id'] = $shiftStore->id;

        $this->assertDatabaseHas('shift_stores', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_shift_store()
    {
        $shiftStore = ShiftStore::factory()->create();

        $response = $this->deleteJson(
            route('api.shift-stores.destroy', $shiftStore)
        );

        $this->assertModelMissing($shiftStore);

        $response->assertNoContent();
    }
}
