<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Departamentos>
 */
class DepartamentosFactory extends Factory
{
    protected $model = \App\Models\Departamentos::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company, // nome fictício para departamento
        ];
    }
}
