<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Utility;
use App\Models\UtilityBill;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UtilityUtilityBillsTest extends TestCase
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
    public function it_gets_utility_utility_bills()
    {
        $utility = Utility::factory()->create();
        $utilityBills = UtilityBill::factory()
            ->count(2)
            ->create([
                'utility_id' => $utility->id,
            ]);

        $response = $this->getJson(
            route('api.utilities.utility-bills.index', $utility)
        );

        $response->assertOk()->assertSee($utilityBills[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_utility_utility_bills()
    {
        $utility = Utility::factory()->create();
        $data = UtilityBill::factory()
            ->make([
                'utility_id' => $utility->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.utilities.utility-bills.store', $utility),
            $data
        );

        $this->assertDatabaseHas('utility_bills', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $utilityBill = UtilityBill::latest('id')->first();

        $this->assertEquals($utility->id, $utilityBill->utility_id);
    }
}
