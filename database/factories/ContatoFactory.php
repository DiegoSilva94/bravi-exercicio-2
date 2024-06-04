<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contato>
 */
class ContatoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tipo = fake()->numberBetween(1,3);
        return [
            'tipo' => $tipo,
            'informacao' => match ($tipo) {
                1 => fake()->phoneNumber(),
                2 => fake()->email(),
                3 => fake()->cellphoneNumber(),
            }
        ];
    }
}
