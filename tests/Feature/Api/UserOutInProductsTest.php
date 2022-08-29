<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\OutInProduct;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserOutInProductsTest extends TestCase
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
    public function it_gets_user_out_in_products()
    {
        $user = User::factory()->create();
        $outInProducts = OutInProduct::factory()
            ->count(2)
            ->create([
                'approved_by_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.out-in-products.index', $user)
        );

        $response->assertOk()->assertSee($outInProducts[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_user_out_in_products()
    {
        $user = User::factory()->create();
        $data = OutInProduct::factory()
            ->make([
                'approved_by_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.out-in-products.store', $user),
            $data
        );

        unset($data['delivery_service_id']);

        $this->assertDatabaseHas('out_in_products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $outInProduct = OutInProduct::latest('id')->first();

        $this->assertEquals($user->id, $outInProduct->approved_by_id);
    }
}
