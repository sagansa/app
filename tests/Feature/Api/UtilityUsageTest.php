<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\UtilityUsage;

use App\Models\Utility;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UtilityUsageTest extends TestCase
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
    public function it_gets_utility_usages_list()
    {
        $utilityUsages = UtilityUsage::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.utility-usages.index'));

        $response->assertOk()->assertSee($utilityUsages[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_utility_usage()
    {
        $data = UtilityUsage::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.utility-usages.store'), $data);

        $this->assertDatabaseHas('utility_usages', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_utility_usage()
    {
        $utilityUsage = UtilityUsage::factory()->create();

        $user = User::factory()->create();
        $user = User::factory()->create();
        $utility = Utility::factory()->create();

        $data = [
            'result' => $this->faker->randomNumber(2),
            'status' => $this->faker->numberBetween(1, 4),
            'notes' => $this->faker->text,
            'created_by_id' => $user->id,
            'approved_by_id' => $user->id,
            'utility_id' => $utility->id,
        ];

        $response = $this->putJson(
            route('api.utility-usages.update', $utilityUsage),
            $data
        );

        $data['id'] = $utilityUsage->id;

        $this->assertDatabaseHas('utility_usages', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_utility_usage()
    {
        $utilityUsage = UtilityUsage::factory()->create();

        $response = $this->deleteJson(
            route('api.utility-usages.destroy', $utilityUsage)
        );

        $this->assertModelMissing($utilityUsage);

        $response->assertNoContent();
    }
}
