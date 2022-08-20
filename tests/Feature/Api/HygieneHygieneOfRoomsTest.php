<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Hygiene;
use App\Models\HygieneOfRoom;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HygieneHygieneOfRoomsTest extends TestCase
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
    public function it_gets_hygiene_hygiene_of_rooms()
    {
        $hygiene = Hygiene::factory()->create();
        $hygieneOfRooms = HygieneOfRoom::factory()
            ->count(2)
            ->create([
                'hygiene_id' => $hygiene->id,
            ]);

        $response = $this->getJson(
            route('api.hygienes.hygiene-of-rooms.index', $hygiene)
        );

        $response->assertOk()->assertSee($hygieneOfRooms[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_hygiene_hygiene_of_rooms()
    {
        $hygiene = Hygiene::factory()->create();
        $data = HygieneOfRoom::factory()
            ->make([
                'hygiene_id' => $hygiene->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.hygienes.hygiene-of-rooms.store', $hygiene),
            $data
        );

        unset($data['hygiene_id']);

        $this->assertDatabaseHas('hygiene_of_rooms', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $hygieneOfRoom = HygieneOfRoom::latest('id')->first();

        $this->assertEquals($hygiene->id, $hygieneOfRoom->hygiene_id);
    }
}
