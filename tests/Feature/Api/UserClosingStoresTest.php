<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ClosingStore;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserClosingStoresTest extends TestCase
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
    public function it_gets_user_closing_stores()
    {
        $user = User::factory()->create();
        $closingStores = ClosingStore::factory()
            ->count(2)
            ->create([
                'approved_by_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.closing-stores.index', $user)
        );

        $response->assertOk()->assertSee($closingStores[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_user_closing_stores()
    {
        $user = User::factory()->create();
        $data = ClosingStore::factory()
            ->make([
                'approved_by_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.closing-stores.store', $user),
            $data
        );

        $this->assertDatabaseHas('closing_stores', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $closingStore = ClosingStore::latest('id')->first();

        $this->assertEquals($user->id, $closingStore->approved_by_id);
    }
}
