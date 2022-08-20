<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Supplier;

use App\Models\Bank;
use App\Models\Regency;
use App\Models\Village;
use App\Models\Province;
use App\Models\District;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SupplierTest extends TestCase
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
    public function it_gets_suppliers_list()
    {
        $suppliers = Supplier::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.suppliers.index'));

        $response->assertOk()->assertSee($suppliers[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_supplier()
    {
        $data = Supplier::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.suppliers.store'), $data);

        unset($data['user_id']);

        $this->assertDatabaseHas('suppliers', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_supplier()
    {
        $supplier = Supplier::factory()->create();

        $province = Province::factory()->create();
        $regency = Regency::factory()->create();
        $district = District::factory()->create();
        $village = Village::factory()->create();
        $bank = Bank::factory()->create();
        $user = User::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'no_telp' => $this->faker->phoneNumber,
            'address' => $this->faker->text,
            'codepos' => $this->faker->randomNumber(5),
            'bank_account_name' => $this->faker->name,
            'bank_account_no' => $this->faker->randomNumber,
            'status' => $this->faker->numberBetween(1, 2),
            'province_id' => $province->id,
            'regency_id' => $regency->id,
            'district_id' => $district->id,
            'village_id' => $village->id,
            'bank_id' => $bank->id,
            'user_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.suppliers.update', $supplier),
            $data
        );

        unset($data['user_id']);

        $data['id'] = $supplier->id;

        $this->assertDatabaseHas('suppliers', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_supplier()
    {
        $supplier = Supplier::factory()->create();

        $response = $this->deleteJson(
            route('api.suppliers.destroy', $supplier)
        );

        $this->assertModelMissing($supplier);

        $response->assertNoContent();
    }
}
