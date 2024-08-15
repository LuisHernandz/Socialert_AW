<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "curp" => strtoupper($this->faker->bothify('????######????##')),
            "apellido" => $this->faker->lastName,
            "nombre" => $this->faker->firstName,
            "email" => $this->faker->unique()->safeEmail,
            "telefono" => $this->faker->unique()->regexify('[0-9]{10}'),
            "direccion" => $this->faker->address,
        ];
    }
}
