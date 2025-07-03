<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Departamentos;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class DepartamentosControllerTest extends TestCase
{
    use RefreshDatabase; // Limpa o banco a cada teste para evitar interferência entre eles

    private User $usuario;

    // Roda antes de cada teste e autentica um usuário para simular acesso protegido
    protected function setUp(): void
    {
        parent::setUp();
        $this->usuario = User::factory()->create();
        $this->actingAs($this->usuario); // Simula usuário autenticado
    }

    // Testa se a rota de index carrega o componente Vue "Departamentos" corretamente
    #[Test]
    public function index_deve_retornar_componente_departamentos()
    {
        $response = $this->get(route('departamentos.index'));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Departamentos'));
    }

    // Testa se a API retorna uma lista de departamentos no formato correto
    #[Test]
    public function list_deve_retornar_todos_os_departamentos()
    {
        Departamentos::factory()->count(3)->create(); // Cria 3 departamentos fictícios

        $response = $this->getJson(route('departamentos.list'));

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'data' => [['id', 'name', 'created_at']]
                 ]); // Verifica a estrutura da resposta JSON
    }

    // Testa se é possível criar um departamento válido via POST
    #[Test]
    public function store_deve_criar_departamento_valido()
    {
        $data = ['name' => 'Financeiro'];

        $response = $this->post(route('departamentos.store'), $data);

        $response->assertRedirect(route('departamentos.index'));
        $this->assertDatabaseHas('departamentos', $data); // Verifica se o registro foi criado
    }

    // Testa se a criação falha quando o nome estiver ausente ou muito curto
    #[Test]
    public function store_deve_falhar_se_nome_ausente_ou_curto()
    {
        // Teste com nome vazio
        $response = $this->post(route('departamentos.store'), ['name' => '']);
        $response->assertSessionHasErrors(['name']);

        // Teste com nome muito curto
        $response = $this->post(route('departamentos.store'), ['name' => 'abc']);
        $response->assertSessionHasErrors(['name']);

        // Nenhum departamento deve ter sido criado
        $this->assertDatabaseCount('departamentos', 0);
    }

    // Testa se é possível atualizar um departamento existente
    #[Test]
    public function update_deve_alterar_departamento_valido()
    {
        $dep = Departamentos::factory()->create(['name' => 'Antigo']);

        $response = $this->put(route('departamentos.update', $dep->id), [
            'name' => 'Atualizado',
        ]);

        $response->assertRedirect(route('departamentos.index'));
        $this->assertDatabaseHas('departamentos', ['id' => $dep->id, 'name' => 'Atualizado']);
    }

    // Testa se falha ao atualizar com nome vazio ou muito curto
    #[Test]
    public function update_deve_falhar_com_nome_vazio_ou_curto()
    {
        $dep = Departamentos::factory()->create();

        $response = $this->put(route('departamentos.update', $dep->id), ['name' => '']);
        $response->assertSessionHasErrors(['name']);

        $response = $this->put(route('departamentos.update', $dep->id), ['name' => 'abc']);
        $response->assertSessionHasErrors(['name']);
    }

    // Testa se não permite dois departamentos com o mesmo nome
    #[Test]
    public function update_deve_falhar_se_nome_duplicado()
    {
        Departamentos::factory()->create(['name' => 'Existente']);
        $dep2 = Departamentos::factory()->create(['name' => 'Outro']);

        $response = $this->put(route('departamentos.update', $dep2->id), [
            'name' => 'Existente',
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    // Garante que o departamento com ID 1 (protegido) não pode ser alterado
    #[Test]
    public function update_nao_deve_alterar_departamento_id_1()
    {
        Departamentos::factory()->create(['id' => 1, 'name' => 'Protegido']);

        $response = $this->put(route('departamentos.update', 1), ['name' => 'Tentativa']);

        $response->assertRedirect(route('departamentos.index'));
        $this->assertDatabaseHas('departamentos', ['id' => 1, 'name' => 'Protegido']);
    }

    // Testa se a exclusão via soft delete está funcionando corretamente
    #[Test]
    public function destroy_deve_excluir_departamento()
    {

        $dep = Departamentos::factory()->create();

        $response = $this->delete(route('departamentos.destroy', $dep->id));

        $response->assertRedirect(route('departamentos.index'));

        // Verifica que o registro foi soft deletado
        $this->assertSoftDeleted('departamentos', ['id' => $dep->id]);
    }
}
