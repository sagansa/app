<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Production;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserProductionsTest extends TestCase
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
    public function it_gets_user_productions()
    {
        $user = User::factory()->create();
        $productions = Production::factory()
            ->count(2)
            ->create([
                'approved_by_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.productions.index', $user));

        $response->assertOk()->assertSee($productions[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_user_productions()
    {
        $user = User::factory()->create();
        $data = Production::factory()
            ->make([
                'approved_by_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.productions.store', $user),
            $data
        );

        $this->assertDatabaseHas('productions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $production = Production::latest('id')->first();

        $this->assertEquals($user->id, $production->approved_by_id);
    }
}
