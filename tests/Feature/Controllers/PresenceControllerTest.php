<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Presence;

use App\Models\PaymentType;
use App\Models\ClosingStore;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PresenceControllerTest extends TestCase
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
    public function it_displays_index_view_with_presences()
    {
        $presences = Presence::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('presences.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.presences.index')
            ->assertViewHas('presences');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_presence()
    {
        $response = $this->get(route('presences.create'));

        $response->assertOk()->assertViewIs('app.presences.create');
    }

    /**
     * @test
     */
    public function it_stores_the_presence()
    {
        $data = Presence::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('presences.store'), $data);

        unset($data['image_in']);
        unset($data['image_out']);
        unset($data['lat_long_in']);
        unset($data['lat_long_out']);
        unset($data['approved_by_id']);

        $this->assertDatabaseHas('presences', $data);

        $presence = Presence::latest('id')->first();

        $response->assertRedirect(route('presences.edit', $presence));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_presence()
    {
        $presence = Presence::factory()->create();

        $response = $this->get(route('presences.show', $presence));

        $response
            ->assertOk()
            ->assertViewIs('app.presences.show')
            ->assertViewHas('presence');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_presence()
    {
        $presence = Presence::factory()->create();

        $response = $this->get(route('presences.edit', $presence));

        $response
            ->assertOk()
            ->assertViewIs('app.presences.edit')
            ->assertViewHas('presence');
    }

    /**
     * @test
     */
    public function it_updates_the_presence()
    {
        $presence = Presence::factory()->create();

        $closingStore = ClosingStore::factory()->create();
        $user = User::factory()->create();
        $user = User::factory()->create();
        $paymentType = PaymentType::factory()->create();

        $data = [
            'amount' => $this->faker->randomNumber,
            'status' => $this->faker->numberBetween(1, 2),
            'image_in' => $this->faker->text(255),
            'image_out' => $this->faker->text(255),
            'lat_long_in' => $this->faker->text(255),
            'lat_long_out' => $this->faker->text(255),
            'closing_store_id' => $closingStore->id,
            'created_by_id' => $user->id,
            'approved_by_id' => $user->id,
            'payment_type_id' => $paymentType->id,
        ];

        $response = $this->put(route('presences.update', $presence), $data);

        unset($data['image_in']);
        unset($data['image_out']);
        unset($data['lat_long_in']);
        unset($data['lat_long_out']);
        unset($data['approved_by_id']);

        $data['id'] = $presence->id;

        $this->assertDatabaseHas('presences', $data);

        $response->assertRedirect(route('presences.edit', $presence));
    }

    /**
     * @test
     */
    public function it_deletes_the_presence()
    {
        $presence = Presence::factory()->create();

        $response = $this->delete(route('presences.destroy', $presence));

        $response->assertRedirect(route('presences.index'));

        $this->assertModelMissing($presence);
    }
}
