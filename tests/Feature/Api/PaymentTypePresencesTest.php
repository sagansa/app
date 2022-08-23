<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Presence;
use App\Models\PaymentType;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentTypePresencesTest extends TestCase
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
    public function it_gets_payment_type_presences()
    {
        $paymentType = PaymentType::factory()->create();
        $presences = Presence::factory()
            ->count(2)
            ->create([
                'payment_type_id' => $paymentType->id,
            ]);

        $response = $this->getJson(
            route('api.payment-types.presences.index', $paymentType)
        );

        $response->assertOk()->assertSee($presences[0]->image_in);
    }

    /**
     * @test
     */
    public function it_stores_the_payment_type_presences()
    {
        $paymentType = PaymentType::factory()->create();
        $data = Presence::factory()
            ->make([
                'payment_type_id' => $paymentType->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.payment-types.presences.store', $paymentType),
            $data
        );

        unset($data['image_in']);
        unset($data['image_out']);
        unset($data['lat_long_in']);
        unset($data['lat_long_out']);
        unset($data['approved_by_id']);

        $this->assertDatabaseHas('presences', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $presence = Presence::latest('id')->first();

        $this->assertEquals($paymentType->id, $presence->payment_type_id);
    }
}
