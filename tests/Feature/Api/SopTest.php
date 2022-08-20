<?php

namespace Tests\Feature\Api;

use App\Models\Sop;
use App\Models\User;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SopTest extends TestCase
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
    public function it_gets_sops_list()
    {
        $sops = Sop::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.sops.index'));

        $response->assertOk()->assertSee($sops[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_sop()
    {
        $data = Sop::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.sops.store'), $data);

        $this->assertDatabaseHas('sops', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_sop()
    {
        $sop = Sop::factory()->create();

        $data = [
            'title' => $this->faker->sentence(10),
            'revision' => $this->faker->randomNumber(0),
            'file' => $this->faker->text(255),
        ];

        $response = $this->putJson(route('api.sops.update', $sop), $data);

        $data['id'] = $sop->id;

        $this->assertDatabaseHas('sops', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_sop()
    {
        $sop = Sop::factory()->create();

        $response = $this->deleteJson(route('api.sops.destroy', $sop));

        $this->assertModelMissing($sop);

        $response->assertNoContent();
    }
}
