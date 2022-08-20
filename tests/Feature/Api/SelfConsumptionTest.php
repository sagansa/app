<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SelfConsumption;

use App\Models\Store;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SelfConsumptionTest extends TestCase
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
    public function it_gets_self_consumptions_list()
    {
        $selfConsumptions = SelfConsumption::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.self-consumptions.index'));

        $response->assertOk()->assertSee($selfConsumptions[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_self_consumption()
    {
        $data = SelfConsumption::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.self-consumptions.store'),
            $data
        );

        $this->assertDatabaseHas('self_consumptions', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_self_consumption()
    {
        $selfConsumption = SelfConsumption::factory()->create();

        $store = Store::factory()->create();
        $user = User::factory()->create();
        $user = User::factory()->create();

        $data = [
            'date' => $this->faker->date,
            'status' => $this->faker->numberBetween(1, 4),
            'notes' => $this->faker->text,
            'store_id' => $store->id,
            'created_by_id' => $user->id,
            'approved_by_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.self-consumptions.update', $selfConsumption),
            $data
        );

        $data['id'] = $selfConsumption->id;

        $this->assertDatabaseHas('self_consumptions', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_self_consumption()
    {
        $selfConsumption = SelfConsumption::factory()->create();

        $response = $this->deleteJson(
            route('api.self-consumptions.destroy', $selfConsumption)
        );

        $this->assertModelMissing($selfConsumption);

        $response->assertNoContent();
    }
}
