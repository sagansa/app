<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\UserCashless;
use App\Models\AdminCashless;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminCashlessUserCashlessesTest extends TestCase
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
    public function it_gets_admin_cashless_user_cashlesses()
    {
        $adminCashless = AdminCashless::factory()->create();
        $userCashlesses = UserCashless::factory()
            ->count(2)
            ->create([
                'admin_cashless_id' => $adminCashless->id,
            ]);

        $response = $this->getJson(
            route('api.admin-cashlesses.user-cashlesses.index', $adminCashless)
        );

        $response->assertOk()->assertSee($userCashlesses[0]->email);
    }

    /**
     * @test
     */
    public function it_stores_the_admin_cashless_user_cashlesses()
    {
        $adminCashless = AdminCashless::factory()->create();
        $data = UserCashless::factory()
            ->make([
                'admin_cashless_id' => $adminCashless->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.admin-cashlesses.user-cashlesses.store', $adminCashless),
            $data
        );

        $this->assertDatabaseHas('user_cashlesses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $userCashless = UserCashless::latest('id')->first();

        $this->assertEquals(
            $adminCashless->id,
            $userCashless->admin_cashless_id
        );
    }
}
