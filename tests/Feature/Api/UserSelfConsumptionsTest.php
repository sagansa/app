<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SelfConsumption;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserSelfConsumptionsTest extends TestCase
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
    public function it_gets_user_self_consumptions()
    {
        $user = User::factory()->create();
        $selfConsumptions = SelfConsumption::factory()
            ->count(2)
            ->create([
                'approved_by_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.self-consumptions.index', $user)
        );

        $response->assertOk()->assertSee($selfConsumptions[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_user_self_consumptions()
    {
        $user = User::factory()->create();
        $data = SelfConsumption::factory()
            ->make([
                'approved_by_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.self-consumptions.store', $user),
            $data
        );

        $this->assertDatabaseHas('self_consumptions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $selfConsumption = SelfConsumption::latest('id')->first();

        $this->assertEquals($user->id, $selfConsumption->approved_by_id);
    }
}
