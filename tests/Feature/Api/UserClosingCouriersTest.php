<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ClosingCourier;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserClosingCouriersTest extends TestCase
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
    public function it_gets_user_closing_couriers()
    {
        $user = User::factory()->create();
        $closingCouriers = ClosingCourier::factory()
            ->count(2)
            ->create([
                'approved_by_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.closing-couriers.index', $user)
        );

        $response->assertOk()->assertSee($closingCouriers[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_user_closing_couriers()
    {
        $user = User::factory()->create();
        $data = ClosingCourier::factory()
            ->make([
                'approved_by_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.closing-couriers.store', $user),
            $data
        );

        unset($data['created_by_id']);
        unset($data['approved_by_id']);

        $this->assertDatabaseHas('closing_couriers', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $closingCourier = ClosingCourier::latest('id')->first();

        $this->assertEquals($user->id, $closingCourier->approved_by_id);
    }
}
