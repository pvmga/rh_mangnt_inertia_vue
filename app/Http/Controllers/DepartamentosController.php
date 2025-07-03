<?php

namespace App\Http\Controllers;

use App\Http\Services\DepartamentoService;
use App\Models\Departamentos;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DepartamentosController extends Controller
{

    protected DepartamentoService $departamentoService;

    public function __construct(DepartamentoService $departamentoService)
    {
        $this->departamentoService = $departamentoService;
    }
    public function index()
    {
        // paginate SEM OS DELETADOS
        $departamentos = Departamentos::orderBy('id')->paginate(10);

        // Formatar o campo created_at antes de enviar
        $departamentos->getCollection()->transform(function ($dpto) {
            $dpto->created_at_formatted = $dpto->created_at->format('d/m/Y H:i');
            return $dpto;
        });

        return Inertia::render('Departamentos', [
            'departamentos' => $departamentos
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:5|max:255|unique:departamentos,name,' . $request->name,
        ]);

        $this->departamentoService->store($validated);
        return redirect()->route('departamentos.index')->with('success', 'Departamento ('.$request->name.') cadastrado com sucesso.');

    }

    public function update(Request $request, Departamentos $departamentos)
    {

        $validated = $request->validate([
            'name' => 'required|string|min:5|max:255|unique:departamentos,name,' . $request->name,
        ]);
        if (intval($departamentos->id) === 1) {
            return redirect()->route('departamentos.index')->with('error', 'Você não poderá atualizar esse Departamento: ' . $departamentos->id);
        }
        $this->departamentoService->update($departamentos, $validated);
        return redirect()->route('departamentos.index')->with('success', 'Departamento alterado com sucesso. Id Departamento: ' . $departamentos->id);
    }

    public function destroy(Departamentos $departamentos)
    {
        $this->departamentoService->delete($departamentos);
        return redirect()->route('departamentos.index')->with('success', 'Departamento excluído com sucesso.');
    }
}
