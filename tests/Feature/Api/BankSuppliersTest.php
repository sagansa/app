<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Bank;
use App\Models\Supplier;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BankSuppliersTest extends TestCase
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
    public function it_gets_bank_suppliers()
    {
        $bank = Bank::factory()->create();
        $suppliers = Supplier::factory()
            ->count(2)
            ->create([
                'bank_id' => $bank->id,
            ]);

        $response = $this->getJson(route('api.banks.suppliers.index', $bank));

        $response->assertOk()->assertSee($suppliers[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_bank_suppliers()
    {
        $bank = Bank::factory()->create();
        $data = Supplier::factory()
            ->make([
                'bank_id' => $bank->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.banks.suppliers.store', $bank),
            $data
        );

        unset($data['user_id']);

        $this->assertDatabaseHas('suppliers', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $supplier = Supplier::latest('id')->first();

        $this->assertEquals($bank->id, $supplier->bank_id);
    }
}
