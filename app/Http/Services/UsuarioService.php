<?php

namespace App\Http\Services;

use App\Models\User;

class UsuarioService
{
    public function store(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);
    }

    public function update(User $user, array $data): User
    {
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        return $user;
    }

    public function delete(User $user): void
    {
        $user = User::findOrFail($user->id);
        $user->delete();
    }
}
