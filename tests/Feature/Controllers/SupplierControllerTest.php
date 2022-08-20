<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Supplier;

use App\Models\Bank;
use App\Models\Regency;
use App\Models\Village;
use App\Models\Province;
use App\Models\District;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SupplierControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_suppliers()
    {
        $suppliers = Supplier::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('suppliers.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.suppliers.index')
            ->assertViewHas('suppliers');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_supplier()
    {
        $response = $this->get(route('suppliers.create'));

        $response->assertOk()->assertViewIs('app.suppliers.create');
    }

    /**
     * @test
     */
    public function it_stores_the_supplier()
    {
        $data = Supplier::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('suppliers.store'), $data);

        unset($data['user_id']);

        $this->assertDatabaseHas('suppliers', $data);

        $supplier = Supplier::latest('id')->first();

        $response->assertRedirect(route('suppliers.edit', $supplier));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_supplier()
    {
        $supplier = Supplier::factory()->create();

        $response = $this->get(route('suppliers.show', $supplier));

        $response
            ->assertOk()
            ->assertViewIs('app.suppliers.show')
            ->assertViewHas('supplier');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_supplier()
    {
        $supplier = Supplier::factory()->create();

        $response = $this->get(route('suppliers.edit', $supplier));

        $response
            ->assertOk()
            ->assertViewIs('app.suppliers.edit')
            ->assertViewHas('supplier');
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

        $response = $this->put(route('suppliers.update', $supplier), $data);

        unset($data['user_id']);

        $data['id'] = $supplier->id;

        $this->assertDatabaseHas('suppliers', $data);

        $response->assertRedirect(route('suppliers.edit', $supplier));
    }

    /**
     * @test
     */
    public function it_deletes_the_supplier()
    {
        $supplier = Supplier::factory()->create();

        $response = $this->delete(route('suppliers.destroy', $supplier));

        $response->assertRedirect(route('suppliers.index'));

        $this->assertModelMissing($supplier);
    }
}
