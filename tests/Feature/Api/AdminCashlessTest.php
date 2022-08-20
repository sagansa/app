<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\AdminCashless;

use App\Models\CashlessProvider;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminCashlessTest extends TestCase
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
    public function it_gets_admin_cashlesses_list()
    {
        $adminCashlesses = AdminCashless::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.admin-cashlesses.index'));

        $response->assertOk()->assertSee($adminCashlesses[0]->username);
    }

    /**
     * @test
     */
    public function it_stores_the_admin_cashless()
    {
        $data = AdminCashless::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.admin-cashlesses.store'), $data);

        $this->assertDatabaseHas('admin_cashlesses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_admin_cashless()
    {
        $adminCashless = AdminCashless::factory()->create();

        $cashlessProvider = CashlessProvider::factory()->create();

        $data = [
            'username' => $this->faker->text(50),
            'email' => $this->faker->email,
            'no_telp' => $this->faker->randomNumber,
            'cashless_provider_id' => $cashlessProvider->id,
        ];

        $response = $this->putJson(
            route('api.admin-cashlesses.update', $adminCashless),
            $data
        );

        $data['id'] = $adminCashless->id;

        $this->assertDatabaseHas('admin_cashlesses', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_admin_cashless()
    {
        $adminCashless = AdminCashless::factory()->create();

        $response = $this->deleteJson(
            route('api.admin-cashlesses.destroy', $adminCashless)
        );

        $this->assertModelMissing($adminCashless);

        $response->assertNoContent();
    }
}
