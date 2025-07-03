<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UsuariosControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_exibe_pagina_usuarios()
    {
        $admin = User::factory()->create();
        $this->actingAs($admin);

        $response = $this->get(route('usuarios.index'));

        $response->assertStatus(200);
    }

    // public function test_list_retorna_usuarios()
    // {
    //     $admin = User::factory()->create();
    //     $this->actingAs($admin);

    //     $user = User::factory()->create();

    //     $response = $this->getJson(route('usuarios.list'));

    //     $response->assertStatus(200)
    //              ->assertJsonFragment(['id' => $user->id]);
    // }

    public function test_store_cria_usuario()
    {
        $admin = User::factory()->create();
        $this->actingAs($admin);

        $dados = [
            'name' => 'Novo Usuario',
            'email' => 'novo@email.com',
            'password' => '12345678',
        ];

        $response = $this->postJson(route('usuarios.store'), $dados);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'name' => 'Novo Usuario',
            'email' => 'novo@email.com',
        ]);

        $user = User::where('email', 'novo@email.com')->first();
        $this->assertTrue(Hash::check('12345678', $user->password));
    }

    public function test_update_atualiza_usuario()
    {
        $admin = User::factory()->create();
        $this->actingAs($admin);

        $user = User::factory()->create();

        $dados = [
            'name' => 'Atualizado',
            'email' => 'novo@email.com',
        ];

        $response = $this->putJson(route('usuarios.update', $user->id), $dados);

        $response->assertStatus(204);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Atualizado',
            'email' => 'novo@email.com',
        ]);
    }

    public function test_destroy_soft_delete_usuario()
    {
        $admin = User::factory()->create();
        $this->actingAs($admin);

        $user = User::factory()->create();

        $response = $this->delete(route('usuarios.destroy', $user->id));

        $response->assertRedirect(route('usuarios.index'));

        $this->assertSoftDeleted('users', [
            'id' => $user->id,
        ]);
    }
}
