<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Utility;
use App\Models\UtiliyUsage;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UtilityUtiliyUsagesTest extends TestCase
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
    public function it_gets_utility_utiliy_usages()
    {
        $utility = Utility::factory()->create();
        $utiliyUsage = UtiliyUsage::factory()->create();

        $utility->utiliyUsages()->attach($utiliyUsage);

        $response = $this->getJson(
            route('api.utilities.utiliy-usages.index', $utility)
        );

        $response->assertOk()->assertSee($utiliyUsage->notes);
    }

    /**
     * @test
     */
    public function it_can_attach_utiliy_usages_to_utility()
    {
        $utility = Utility::factory()->create();
        $utiliyUsage = UtiliyUsage::factory()->create();

        $response = $this->postJson(
            route('api.utilities.utiliy-usages.store', [$utility, $utiliyUsage])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $utility
                ->utiliyUsages()
                ->where('utiliy_usages.id', $utiliyUsage->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_utiliy_usages_from_utility()
    {
        $utility = Utility::factory()->create();
        $utiliyUsage = UtiliyUsage::factory()->create();

        $response = $this->deleteJson(
            route('api.utilities.utiliy-usages.store', [$utility, $utiliyUsage])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $utility
                ->utiliyUsages()
                ->where('utiliy_usages.id', $utiliyUsage->id)
                ->exists()
        );
    }
}
