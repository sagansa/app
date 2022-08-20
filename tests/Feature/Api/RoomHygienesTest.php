<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Room;
use App\Models\Hygiene;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoomHygienesTest extends TestCase
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
    public function it_gets_room_hygienes()
    {
        $room = Room::factory()->create();
        $hygiene = Hygiene::factory()->create();

        $room->hygienes()->attach($hygiene);

        $response = $this->getJson(route('api.rooms.hygienes.index', $room));

        $response->assertOk()->assertSee($hygiene->notes);
    }

    /**
     * @test
     */
    public function it_can_attach_hygienes_to_room()
    {
        $room = Room::factory()->create();
        $hygiene = Hygiene::factory()->create();

        $response = $this->postJson(
            route('api.rooms.hygienes.store', [$room, $hygiene])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $room
                ->hygienes()
                ->where('hygienes.id', $hygiene->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_hygienes_from_room()
    {
        $room = Room::factory()->create();
        $hygiene = Hygiene::factory()->create();

        $response = $this->deleteJson(
            route('api.rooms.hygienes.store', [$room, $hygiene])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $room
                ->hygienes()
                ->where('hygienes.id', $hygiene->id)
                ->exists()
        );
    }
}
