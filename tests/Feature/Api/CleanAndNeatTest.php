<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\CleanAndNeat;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CleanAndNeatTest extends TestCase
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
    public function it_gets_clean_and_neats_list()
    {
        $cleanAndNeats = CleanAndNeat::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.clean-and-neats.index'));

        $response->assertOk()->assertSee($cleanAndNeats[0]->left_hand);
    }

    /**
     * @test
     */
    public function it_stores_the_clean_and_neat()
    {
        $data = CleanAndNeat::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.clean-and-neats.store'), $data);

        $this->assertDatabaseHas('clean_and_neats', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_clean_and_neat()
    {
        $cleanAndNeat = CleanAndNeat::factory()->create();

        $user = User::factory()->create();
        $user = User::factory()->create();

        $data = [
            'left_hand' => $this->faker->text(255),
            'right_hand' => $this->faker->text(255),
            'status' => $this->faker->numberBetween(1, 4),
            'notes' => $this->faker->text,
            'created_by_id' => $user->id,
            'approved_by_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.clean-and-neats.update', $cleanAndNeat),
            $data
        );

        $data['id'] = $cleanAndNeat->id;

        $this->assertDatabaseHas('clean_and_neats', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_clean_and_neat()
    {
        $cleanAndNeat = CleanAndNeat::factory()->create();

        $response = $this->deleteJson(
            route('api.clean-and-neats.destroy', $cleanAndNeat)
        );

        $this->assertModelMissing($cleanAndNeat);

        $response->assertNoContent();
    }
}
