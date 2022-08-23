<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Presence;
use App\Models\ClosingStore;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClosingStorePresencesTest extends TestCase
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
    public function it_gets_closing_store_presences()
    {
        $closingStore = ClosingStore::factory()->create();
        $presences = Presence::factory()
            ->count(2)
            ->create([
                'closing_store_id' => $closingStore->id,
            ]);

        $response = $this->getJson(
            route('api.closing-stores.presences.index', $closingStore)
        );

        $response->assertOk()->assertSee($presences[0]->image_in);
    }

    /**
     * @test
     */
    public function it_stores_the_closing_store_presences()
    {
        $closingStore = ClosingStore::factory()->create();
        $data = Presence::factory()
            ->make([
                'closing_store_id' => $closingStore->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.closing-stores.presences.store', $closingStore),
            $data
        );

        unset($data['image_in']);
        unset($data['image_out']);
        unset($data['lat_long_in']);
        unset($data['lat_long_out']);
        unset($data['approved_by_id']);

        $this->assertDatabaseHas('presences', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $presence = Presence::latest('id')->first();

        $this->assertEquals($closingStore->id, $presence->closing_store_id);
    }
}
