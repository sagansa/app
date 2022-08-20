<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Hygiene;

use App\Models\Store;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HygieneTest extends TestCase
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
    public function it_gets_hygienes_list()
    {
        $hygienes = Hygiene::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.hygienes.index'));

        $response->assertOk()->assertSee($hygienes[0]->notes);
    }

    /**
     * @test
     */
    public function it_stores_the_hygiene()
    {
        $data = Hygiene::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.hygienes.store'), $data);

        $this->assertDatabaseHas('hygienes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_hygiene()
    {
        $hygiene = Hygiene::factory()->create();

        $store = Store::factory()->create();
        $user = User::factory()->create();
        $user = User::factory()->create();

        $data = [
            'status' => $this->faker->numberBetween(1, 4),
            'notes' => $this->faker->text,
            'store_id' => $store->id,
            'created_by_id' => $user->id,
            'approved_by_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.hygienes.update', $hygiene),
            $data
        );

        $data['id'] = $hygiene->id;

        $this->assertDatabaseHas('hygienes', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_hygiene()
    {
        $hygiene = Hygiene::factory()->create();

        $response = $this->deleteJson(route('api.hygienes.destroy', $hygiene));

        $this->assertModelMissing($hygiene);

        $response->assertNoContent();
    }
}
