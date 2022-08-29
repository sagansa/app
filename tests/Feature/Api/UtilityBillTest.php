<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\UtilityBill;

use App\Models\Utility;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UtilityBillTest extends TestCase
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
    public function it_gets_utility_bills_list()
    {
        $utilityBills = UtilityBill::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.utility-bills.index'));

        $response->assertOk()->assertSee($utilityBills[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_utility_bill()
    {
        $data = UtilityBill::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.utility-bills.store'), $data);

        $this->assertDatabaseHas('utility_bills', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_utility_bill()
    {
        $utilityBill = UtilityBill::factory()->create();

        $utility = Utility::factory()->create();

        $data = [
            'date' => $this->faker->date,
            'amount' => $this->faker->text(255),
            'initial_indicator' => $this->faker->randomNumber(2),
            'last_indicator' => $this->faker->randomNumber(2),
            'utility_id' => $utility->id,
        ];

        $response = $this->putJson(
            route('api.utility-bills.update', $utilityBill),
            $data
        );

        $data['id'] = $utilityBill->id;

        $this->assertDatabaseHas('utility_bills', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_utility_bill()
    {
        $utilityBill = UtilityBill::factory()->create();

        $response = $this->deleteJson(
            route('api.utility-bills.destroy', $utilityBill)
        );

        $this->assertModelMissing($utilityBill);

        $response->assertNoContent();
    }
}
