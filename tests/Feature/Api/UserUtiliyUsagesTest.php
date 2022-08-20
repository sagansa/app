<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\UtiliyUsage;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserUtiliyUsagesTest extends TestCase
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
    public function it_gets_user_utiliy_usages()
    {
        $user = User::factory()->create();
        $utiliyUsages = UtiliyUsage::factory()
            ->count(2)
            ->create([
                'approved_by_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.utiliy-usages.index', $user)
        );

        $response->assertOk()->assertSee($utiliyUsages[0]->notes);
    }

    /**
     * @test
     */
    public function it_stores_the_user_utiliy_usages()
    {
        $user = User::factory()->create();
        $data = UtiliyUsage::factory()
            ->make([
                'approved_by_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.utiliy-usages.store', $user),
            $data
        );

        $this->assertDatabaseHas('utiliy_usages', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $utiliyUsage = UtiliyUsage::latest('id')->first();

        $this->assertEquals($user->id, $utiliyUsage->approved_by_id);
    }
}
