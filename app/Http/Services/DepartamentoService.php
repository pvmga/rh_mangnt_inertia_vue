<?php

namespace App\Http\Services;

use App\Models\Departamentos;

class DepartamentoService
{
    public function store(array $data): Departamentos
    {
        return Departamentos::create([
            'name' => $data['name'],
        ]);
    }

    public function update(Departamentos $departamentos, array $data): Departamentos
    {
        $departamentos->update([
            'name' => $data['name'],
        ]);

        return $departamentos;
    }

    public function delete(Departamentos $departamentos) {
        $departamentos = Departamentos::findOrFail($departamentos->id);
        $departamentos->delete();
    }
}
