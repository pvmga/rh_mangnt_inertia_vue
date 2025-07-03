<?php

namespace App\Http\Controllers;

use App\Models\Departamentos;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DepartamentosController extends Controller
{
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

        Departamentos::create([
            'name' => $validated['name'],
        ]);

        return redirect()->route('departamentos.index')->with('success', 'Departamento ('.$request->name.') cadastrado com sucesso.');
        // return response()->json($departamento, 201);
    }

    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'name' => 'required|string|min:5|max:255|unique:departamentos,name,' . $request->name,
        ]);

        if (intval($id) === 1) {
            return redirect()->route('departamentos.index')->with('error', 'Você não poderá atualizar esse Departamento: ' . $id);
        }

        $departamento = Departamentos::findOrFail($id);
        $departamento->update(['name' => $validated['name']]);

        return redirect()->route('departamentos.index')->with('success', 'Departamento alterado com sucesso. Id Departamento: ' . $id);
    }

    public function destroy($id)
    {
        Departamentos::findOrFail($id)->delete();

        return redirect()->route('departamentos.index')->with('success', 'Departamento excluído com sucesso.');
    }
}
