<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\PaymentType;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentTypeProductsTest extends TestCase
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
    public function it_gets_payment_type_products()
    {
        $paymentType = PaymentType::factory()->create();
        $products = Product::factory()
            ->count(2)
            ->create([
                'payment_type_id' => $paymentType->id,
            ]);

        $response = $this->getJson(
            route('api.payment-types.products.index', $paymentType)
        );

        $response->assertOk()->assertSee($products[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_payment_type_products()
    {
        $paymentType = PaymentType::factory()->create();
        $data = Product::factory()
            ->make([
                'payment_type_id' => $paymentType->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.payment-types.products.store', $paymentType),
            $data
        );

        unset($data['user_id']);

        $this->assertDatabaseHas('products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $product = Product::latest('id')->first();

        $this->assertEquals($paymentType->id, $product->payment_type_id);
    }
}
