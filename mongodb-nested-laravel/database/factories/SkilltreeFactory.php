<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Skilltree>
 */
class SkilltreeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->title,
        ];
    }

    public function skills(int $depth): Factory
    {
        return $this->state(function (array $attributes) use ($depth) {
            return [
                'skills' => [
                    $this->generateSkillTree($depth)
                ],
            ];
        });
    }

    private function generateSkillTree($depth) {
        if ($depth <= 0) {
            return null;
        }

        $skillTree = [
            'uuid' => Str::uuid(),
            'name' => $this->faker->title,
            'skills' => [
                $this->generateSkillTree($depth - 1)
            ],
        ];

        return $skillTree;
    }
}
