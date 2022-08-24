<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\StoreCashless;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoreCashlessTest extends TestCase
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
    public function it_gets_store_cashlesses_list()
    {
        $storeCashlesses = StoreCashless::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.store-cashlesses.index'));

        $response->assertOk()->assertSee($storeCashlesses[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_store_cashless()
    {
        $data = StoreCashless::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.store-cashlesses.store'), $data);

        $this->assertDatabaseHas('store_cashlesses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_store_cashless()
    {
        $storeCashless = StoreCashless::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'status' => $this->faker->numberBetween(1, 2),
        ];

        $response = $this->putJson(
            route('api.store-cashlesses.update', $storeCashless),
            $data
        );

        $data['id'] = $storeCashless->id;

        $this->assertDatabaseHas('store_cashlesses', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_store_cashless()
    {
        $storeCashless = StoreCashless::factory()->create();

        $response = $this->deleteJson(
            route('api.store-cashlesses.destroy', $storeCashless)
        );

        $this->assertModelMissing($storeCashless);

        $response->assertNoContent();
    }
}
