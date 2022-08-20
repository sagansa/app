<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ClosingCourier;

use App\Models\Bank;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClosingCourierTest extends TestCase
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
    public function it_gets_closing_couriers_list()
    {
        $closingCouriers = ClosingCourier::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.closing-couriers.index'));

        $response->assertOk()->assertSee($closingCouriers[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_closing_courier()
    {
        $data = ClosingCourier::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.closing-couriers.store'), $data);

        unset($data['created_by_id']);
        unset($data['approved_by_id']);

        $this->assertDatabaseHas('closing_couriers', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_closing_courier()
    {
        $closingCourier = ClosingCourier::factory()->create();

        $bank = Bank::factory()->create();
        $user = User::factory()->create();
        $user = User::factory()->create();

        $data = [
            'total_cash_to_transfer' => $this->faker->randomNumber,
            'status' => $this->faker->numberBetween(1, 4),
            'notes' => $this->faker->text,
            'bank_id' => $bank->id,
            'created_by_id' => $user->id,
            'approved_by_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.closing-couriers.update', $closingCourier),
            $data
        );

        unset($data['created_by_id']);
        unset($data['approved_by_id']);

        $data['id'] = $closingCourier->id;

        $this->assertDatabaseHas('closing_couriers', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_closing_courier()
    {
        $closingCourier = ClosingCourier::factory()->create();

        $response = $this->deleteJson(
            route('api.closing-couriers.destroy', $closingCourier)
        );

        $this->assertModelMissing($closingCourier);

        $response->assertNoContent();
    }
}
