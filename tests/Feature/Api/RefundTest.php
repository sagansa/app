<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Refund;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RefundTest extends TestCase
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
    public function it_gets_refunds_list()
    {
        $refunds = Refund::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.refunds.index'));

        $response->assertOk()->assertSee($refunds[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_refund()
    {
        $data = Refund::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.refunds.store'), $data);

        $this->assertDatabaseHas('refunds', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_refund()
    {
        $refund = Refund::factory()->create();

        $user = User::factory()->create();

        $data = [
            'status' => $this->faker->numberBetween(1, 4),
            'notes' => $this->faker->text,
            'user_id' => $user->id,
        ];

        $response = $this->putJson(route('api.refunds.update', $refund), $data);

        $data['id'] = $refund->id;

        $this->assertDatabaseHas('refunds', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_refund()
    {
        $refund = Refund::factory()->create();

        $response = $this->deleteJson(route('api.refunds.destroy', $refund));

        $this->assertModelMissing($refund);

        $response->assertNoContent();
    }
}
