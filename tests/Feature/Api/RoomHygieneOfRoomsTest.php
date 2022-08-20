<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Room;
use App\Models\HygieneOfRoom;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoomHygieneOfRoomsTest extends TestCase
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
    public function it_gets_room_hygiene_of_rooms()
    {
        $room = Room::factory()->create();
        $hygieneOfRooms = HygieneOfRoom::factory()
            ->count(2)
            ->create([
                'room_id' => $room->id,
            ]);

        $response = $this->getJson(
            route('api.rooms.hygiene-of-rooms.index', $room)
        );

        $response->assertOk()->assertSee($hygieneOfRooms[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_room_hygiene_of_rooms()
    {
        $room = Room::factory()->create();
        $data = HygieneOfRoom::factory()
            ->make([
                'room_id' => $room->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.rooms.hygiene-of-rooms.store', $room),
            $data
        );

        unset($data['hygiene_id']);

        $this->assertDatabaseHas('hygiene_of_rooms', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $hygieneOfRoom = HygieneOfRoom::latest('id')->first();

        $this->assertEquals($room->id, $hygieneOfRoom->room_id);
    }
}
