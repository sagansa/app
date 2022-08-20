<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\SelfConsumption;

use App\Models\Store;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SelfConsumptionControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_self_consumptions()
    {
        $selfConsumptions = SelfConsumption::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('self-consumptions.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.self_consumptions.index')
            ->assertViewHas('selfConsumptions');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_self_consumption()
    {
        $response = $this->get(route('self-consumptions.create'));

        $response->assertOk()->assertViewIs('app.self_consumptions.create');
    }

    /**
     * @test
     */
    public function it_stores_the_self_consumption()
    {
        $data = SelfConsumption::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('self-consumptions.store'), $data);

        $this->assertDatabaseHas('self_consumptions', $data);

        $selfConsumption = SelfConsumption::latest('id')->first();

        $response->assertRedirect(
            route('self-consumptions.edit', $selfConsumption)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_self_consumption()
    {
        $selfConsumption = SelfConsumption::factory()->create();

        $response = $this->get(
            route('self-consumptions.show', $selfConsumption)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.self_consumptions.show')
            ->assertViewHas('selfConsumption');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_self_consumption()
    {
        $selfConsumption = SelfConsumption::factory()->create();

        $response = $this->get(
            route('self-consumptions.edit', $selfConsumption)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.self_consumptions.edit')
            ->assertViewHas('selfConsumption');
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

        $response = $this->put(
            route('self-consumptions.update', $selfConsumption),
            $data
        );

        $data['id'] = $selfConsumption->id;

        $this->assertDatabaseHas('self_consumptions', $data);

        $response->assertRedirect(
            route('self-consumptions.edit', $selfConsumption)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_self_consumption()
    {
        $selfConsumption = SelfConsumption::factory()->create();

        $response = $this->delete(
            route('self-consumptions.destroy', $selfConsumption)
        );

        $response->assertRedirect(route('self-consumptions.index'));

        $this->assertModelMissing($selfConsumption);
    }
}
