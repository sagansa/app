<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\CleanAndNeat;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserCleanAndNeatsTest extends TestCase
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
    public function it_gets_user_clean_and_neats()
    {
        $user = User::factory()->create();
        $cleanAndNeats = CleanAndNeat::factory()
            ->count(2)
            ->create([
                'approved_by_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.clean-and-neats.index', $user)
        );

        $response->assertOk()->assertSee($cleanAndNeats[0]->left_hand);
    }

    /**
     * @test
     */
    public function it_stores_the_user_clean_and_neats()
    {
        $user = User::factory()->create();
        $data = CleanAndNeat::factory()
            ->make([
                'approved_by_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.clean-and-neats.store', $user),
            $data
        );

        $this->assertDatabaseHas('clean_and_neats', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $cleanAndNeat = CleanAndNeat::latest('id')->first();

        $this->assertEquals($user->id, $cleanAndNeat->approved_by_id);
    }
}
