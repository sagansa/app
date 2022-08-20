<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Utility;
use App\Models\UtilityUsage;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UtilityUtilityUsagesTest extends TestCase
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
    public function it_gets_utility_utility_usages()
    {
        $utility = Utility::factory()->create();
        $utilityUsages = UtilityUsage::factory()
            ->count(2)
            ->create([
                'utility_id' => $utility->id,
            ]);

        $response = $this->getJson(
            route('api.utilities.utility-usages.index', $utility)
        );

        $response->assertOk()->assertSee($utilityUsages[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_utility_utility_usages()
    {
        $utility = Utility::factory()->create();
        $data = UtilityUsage::factory()
            ->make([
                'utility_id' => $utility->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.utilities.utility-usages.store', $utility),
            $data
        );

        $this->assertDatabaseHas('utility_usages', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $utilityUsage = UtilityUsage::latest('id')->first();

        $this->assertEquals($utility->id, $utilityUsage->utility_id);
    }
}
