<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Http\Services\UsuarioService;
use Inertia\Inertia;

class UsuariosController extends Controller
{
    protected UsuarioService $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function index()
    {
        // test paginate SEM OS DELETADOS
        $usuarios = User::orderBy('id')->paginate(10);

        // Com os DELETADOS
        // $usuarios = User::withTrashed()
        //     ->orderBy('name')
        //     ->paginate(10);

        return Inertia::render('Usuarios', [
            'usuarios' => $usuarios
        ]);
    }

    // public function list()
    // {
    //     $usuarios = User::all();

    //     return response()->json([
    //         'success' => true,
    //         'data' => $usuarios,
    //     ]);
    // }

    public function store(StoreUsuarioRequest $request)
    {
        $this->usuarioService->store($request->validated());
        return redirect()->route('usuarios.index')->with('success', 'Usuario cadastrado com sucesso. Usuario: ' . $request->name);
    }

    public function update(UpdateUsuarioRequest $request, User $user)
    {
        if (intval($user->id) === 1) {
            return redirect()->route('usuarios.index')->with('error', 'Você não poderá atualizar esse Usuário: ' . $user->name);
        }
        $this->usuarioService->update($user, $request->validated());
        return redirect()->route('usuarios.index')->with('success', 'Usuario alterado com sucesso. Usuario: ' . $user->name);
    }

    public function destroy(User $user)
    {
        try {
            $this->usuarioService->delete($user);
            $this->logInfo($user->id);

            return redirect()->route('usuarios.index')
                ->with('success', 'Usuário excluído com sucesso.');
        } catch (\Exception $e) {
            $this->logError($user->id, $e);

            return redirect()->route('usuarios.index')
                ->with('error', 'Erro ao excluir o usuário.');
        }
    }

    private function logInfo($id)
    {
        Log::info('Usuário excluído com sucesso: ', [
            'id' => $id,
            'user_id' => Auth::id()
        ]);
    }

    private function logError($id, $e)
    {
        Log::error('Erro ao excluir o usuário: ', [
            'id' => $id,
            'user_id' => Auth::id(),
            'exception' => $e->getMessage()
        ]);
    }
}
