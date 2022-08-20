<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Bank;
use App\Models\ClosingCourier;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BankClosingCouriersTest extends TestCase
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
    public function it_gets_bank_closing_couriers()
    {
        $bank = Bank::factory()->create();
        $closingCouriers = ClosingCourier::factory()
            ->count(2)
            ->create([
                'bank_id' => $bank->id,
            ]);

        $response = $this->getJson(
            route('api.banks.closing-couriers.index', $bank)
        );

        $response->assertOk()->assertSee($closingCouriers[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_bank_closing_couriers()
    {
        $bank = Bank::factory()->create();
        $data = ClosingCourier::factory()
            ->make([
                'bank_id' => $bank->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.banks.closing-couriers.store', $bank),
            $data
        );

        unset($data['created_by_id']);
        unset($data['approved_by_id']);

        $this->assertDatabaseHas('closing_couriers', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $closingCourier = ClosingCourier::latest('id')->first();

        $this->assertEquals($bank->id, $closingCourier->bank_id);
    }
}
