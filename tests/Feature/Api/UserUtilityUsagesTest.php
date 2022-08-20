<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\UtilityUsage;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserUtilityUsagesTest extends TestCase
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
    public function it_gets_user_utility_usages()
    {
        $user = User::factory()->create();
        $utilityUsages = UtilityUsage::factory()
            ->count(2)
            ->create([
                'approved_by_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.utility-usages.index', $user)
        );

        $response->assertOk()->assertSee($utilityUsages[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_user_utility_usages()
    {
        $user = User::factory()->create();
        $data = UtilityUsage::factory()
            ->make([
                'approved_by_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.utility-usages.store', $user),
            $data
        );

        $this->assertDatabaseHas('utility_usages', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $utilityUsage = UtilityUsage::latest('id')->first();

        $this->assertEquals($user->id, $utilityUsage->approved_by_id);
    }
}
