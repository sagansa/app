<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\UtilityConsumption;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserUtilityConsumptionsTest extends TestCase
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
    public function it_gets_user_utility_consumptions()
    {
        $user = User::factory()->create();
        $utilityConsumptions = UtilityConsumption::factory()
            ->count(2)
            ->create([
                'approved_by_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.utility-consumptions.index', $user)
        );

        $response->assertOk()->assertSee($utilityConsumptions[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_user_utility_consumptions()
    {
        $user = User::factory()->create();
        $data = UtilityConsumption::factory()
            ->make([
                'approved_by_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.utility-consumptions.store', $user),
            $data
        );

        $this->assertDatabaseHas('utility_consumptions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $utilityConsumption = UtilityConsumption::latest('id')->first();

        $this->assertEquals($user->id, $utilityConsumption->approved_by_id);
    }
}
