<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // admin department
        DB::table('departamentos')->insert([
            'name' => 'Administração',
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        // admin user
        DB::table('users')->insert([
            'name' => 'Paulo Vinicius',
            'email' => 'vpaulo95@yahoo.com.br',
            'email_verified_at' => now(),
            'created_at' => now(),
            'password' => bcrypt('12345678'),
            'remember_token' => Str::random(10),
        ]);

        //
        DB::table('users')->insert([
            'name' => 'Jheniffer Caroline',
            'email' => 'paulomartim93@gmail.com',
            'email_verified_at' => now(),
            'created_at' => now(),
            'password' => bcrypt('12345678'),
            'remember_token' => Str::random(10),
        ]);

        \App\Models\User::factory(50000)->create();

        \App\Models\Departamentos::factory(5000)->create();
    }
}
