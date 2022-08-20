<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\UserCashless;

use App\Models\Store;
use App\Models\AdminCashless;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserCashlessTest extends TestCase
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
    public function it_gets_user_cashlesses_list()
    {
        $userCashlesses = UserCashless::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.user-cashlesses.index'));

        $response->assertOk()->assertSee($userCashlesses[0]->email);
    }

    /**
     * @test
     */
    public function it_stores_the_user_cashless()
    {
        $data = UserCashless::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.user-cashlesses.store'), $data);

        $this->assertDatabaseHas('user_cashlesses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_user_cashless()
    {
        $userCashless = UserCashless::factory()->create();

        $adminCashless = AdminCashless::factory()->create();
        $store = Store::factory()->create();

        $data = [
            'email' => $this->faker->email,
            'username' => $this->faker->text(50),
            'no_telp' => $this->faker->randomNumber,
            'admin_cashless_id' => $adminCashless->id,
            'store_id' => $store->id,
        ];

        $response = $this->putJson(
            route('api.user-cashlesses.update', $userCashless),
            $data
        );

        $data['id'] = $userCashless->id;

        $this->assertDatabaseHas('user_cashlesses', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_user_cashless()
    {
        $userCashless = UserCashless::factory()->create();

        $response = $this->deleteJson(
            route('api.user-cashlesses.destroy', $userCashless)
        );

        $this->assertModelMissing($userCashless);

        $response->assertNoContent();
    }
}
