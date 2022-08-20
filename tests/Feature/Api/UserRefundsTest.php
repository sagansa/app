<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Refund;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRefundsTest extends TestCase
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
    public function it_gets_user_refunds()
    {
        $user = User::factory()->create();
        $refunds = Refund::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.refunds.index', $user));

        $response->assertOk()->assertSee($refunds[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_user_refunds()
    {
        $user = User::factory()->create();
        $data = Refund::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.refunds.store', $user),
            $data
        );

        $this->assertDatabaseHas('refunds', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $refund = Refund::latest('id')->first();

        $this->assertEquals($user->id, $refund->user_id);
    }
}
