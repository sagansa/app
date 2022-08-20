<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Refund;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RefundControllerTest extends TestCase
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
    public function it_displays_index_view_with_refunds()
    {
        $refunds = Refund::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('refunds.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.refunds.index')
            ->assertViewHas('refunds');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_refund()
    {
        $response = $this->get(route('refunds.create'));

        $response->assertOk()->assertViewIs('app.refunds.create');
    }

    /**
     * @test
     */
    public function it_stores_the_refund()
    {
        $data = Refund::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('refunds.store'), $data);

        $this->assertDatabaseHas('refunds', $data);

        $refund = Refund::latest('id')->first();

        $response->assertRedirect(route('refunds.edit', $refund));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_refund()
    {
        $refund = Refund::factory()->create();

        $response = $this->get(route('refunds.show', $refund));

        $response
            ->assertOk()
            ->assertViewIs('app.refunds.show')
            ->assertViewHas('refund');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_refund()
    {
        $refund = Refund::factory()->create();

        $response = $this->get(route('refunds.edit', $refund));

        $response
            ->assertOk()
            ->assertViewIs('app.refunds.edit')
            ->assertViewHas('refund');
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

        $response = $this->put(route('refunds.update', $refund), $data);

        $data['id'] = $refund->id;

        $this->assertDatabaseHas('refunds', $data);

        $response->assertRedirect(route('refunds.edit', $refund));
    }

    /**
     * @test
     */
    public function it_deletes_the_refund()
    {
        $refund = Refund::factory()->create();

        $response = $this->delete(route('refunds.destroy', $refund));

        $response->assertRedirect(route('refunds.index'));

        $this->assertModelMissing($refund);
    }
}
