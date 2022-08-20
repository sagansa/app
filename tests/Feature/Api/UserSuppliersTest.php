<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Supplier;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserSuppliersTest extends TestCase
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
    public function it_gets_user_suppliers()
    {
        $user = User::factory()->create();
        $suppliers = Supplier::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.suppliers.index', $user));

        $response->assertOk()->assertSee($suppliers[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_user_suppliers()
    {
        $user = User::factory()->create();
        $data = Supplier::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.suppliers.store', $user),
            $data
        );

        unset($data['user_id']);

        $this->assertDatabaseHas('suppliers', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $supplier = Supplier::latest('id')->first();

        $this->assertEquals($user->id, $supplier->user_id);
    }
}
