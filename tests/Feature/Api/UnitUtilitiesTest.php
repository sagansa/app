<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Unit;
use App\Models\Utility;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnitUtilitiesTest extends TestCase
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
    public function it_gets_unit_utilities()
    {
        $unit = Unit::factory()->create();
        $utilities = Utility::factory()
            ->count(2)
            ->create([
                'unit_id' => $unit->id,
            ]);

        $response = $this->getJson(route('api.units.utilities.index', $unit));

        $response->assertOk()->assertSee($utilities[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_unit_utilities()
    {
        $unit = Unit::factory()->create();
        $data = Utility::factory()
            ->make([
                'unit_id' => $unit->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.units.utilities.store', $unit),
            $data
        );

        $this->assertDatabaseHas('utilities', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $utility = Utility::latest('id')->first();

        $this->assertEquals($unit->id, $utility->unit_id);
    }
}
