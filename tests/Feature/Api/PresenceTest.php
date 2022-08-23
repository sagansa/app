<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Presence;

use App\Models\PaymentType;
use App\Models\ClosingStore;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PresenceTest extends TestCase
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
    public function it_gets_presences_list()
    {
        $presences = Presence::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.presences.index'));

        $response->assertOk()->assertSee($presences[0]->image_in);
    }

    /**
     * @test
     */
    public function it_stores_the_presence()
    {
        $data = Presence::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.presences.store'), $data);

        unset($data['image_in']);
        unset($data['image_out']);
        unset($data['lat_long_in']);
        unset($data['lat_long_out']);
        unset($data['approved_by_id']);

        $this->assertDatabaseHas('presences', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_presence()
    {
        $presence = Presence::factory()->create();

        $closingStore = ClosingStore::factory()->create();
        $user = User::factory()->create();
        $user = User::factory()->create();
        $paymentType = PaymentType::factory()->create();

        $data = [
            'amount' => $this->faker->randomNumber,
            'status' => $this->faker->numberBetween(1, 2),
            'image_in' => $this->faker->text(255),
            'image_out' => $this->faker->text(255),
            'lat_long_in' => $this->faker->text(255),
            'lat_long_out' => $this->faker->text(255),
            'closing_store_id' => $closingStore->id,
            'created_by_id' => $user->id,
            'approved_by_id' => $user->id,
            'payment_type_id' => $paymentType->id,
        ];

        $response = $this->putJson(
            route('api.presences.update', $presence),
            $data
        );

        unset($data['image_in']);
        unset($data['image_out']);
        unset($data['lat_long_in']);
        unset($data['lat_long_out']);
        unset($data['approved_by_id']);

        $data['id'] = $presence->id;

        $this->assertDatabaseHas('presences', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_presence()
    {
        $presence = Presence::factory()->create();

        $response = $this->deleteJson(
            route('api.presences.destroy', $presence)
        );

        $this->assertModelMissing($presence);

        $response->assertNoContent();
    }
}
