<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Room;
use App\Models\Hygiene;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HygieneRoomsTest extends TestCase
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
    public function it_gets_hygiene_rooms()
    {
        $hygiene = Hygiene::factory()->create();
        $room = Room::factory()->create();

        $hygiene->rooms()->attach($room);

        $response = $this->getJson(route('api.hygienes.rooms.index', $hygiene));

        $response->assertOk()->assertSee($room->name);
    }

    /**
     * @test
     */
    public function it_can_attach_rooms_to_hygiene()
    {
        $hygiene = Hygiene::factory()->create();
        $room = Room::factory()->create();

        $response = $this->postJson(
            route('api.hygienes.rooms.store', [$hygiene, $room])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $hygiene
                ->rooms()
                ->where('rooms.id', $room->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_rooms_from_hygiene()
    {
        $hygiene = Hygiene::factory()->create();
        $room = Room::factory()->create();

        $response = $this->deleteJson(
            route('api.hygienes.rooms.store', [$hygiene, $room])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $hygiene
                ->rooms()
                ->where('rooms.id', $room->id)
                ->exists()
        );
    }
}
