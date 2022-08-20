<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Production;
use App\Models\ProductionSupportFrom;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductionProductionSupportFromsTest extends TestCase
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
    public function it_gets_production_production_support_froms()
    {
        $production = Production::factory()->create();
        $productionSupportFroms = ProductionSupportFrom::factory()
            ->count(2)
            ->create([
                'production_id' => $production->id,
            ]);

        $response = $this->getJson(
            route('api.productions.production-support-froms.index', $production)
        );

        $response->assertOk()->assertSee($productionSupportFroms[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_production_production_support_froms()
    {
        $production = Production::factory()->create();
        $data = ProductionSupportFrom::factory()
            ->make([
                'production_id' => $production->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route(
                'api.productions.production-support-froms.store',
                $production
            ),
            $data
        );

        unset($data['production_id']);

        $this->assertDatabaseHas('production_support_froms', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $productionSupportFrom = ProductionSupportFrom::latest('id')->first();

        $this->assertEquals(
            $production->id,
            $productionSupportFrom->production_id
        );
    }
}
