<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SkillEvidence>
 */
class SkillEvidenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'explanation' => $this->faker->text,
        ];
    }

    public function student(Student $student): Factory
    {
        return $this->state(function (array $attributes) use ($student) {
            return [
                'student_id' => $student->id,
            ];
        });
    }

    public function skill(string $skillUuid): Factory
    {
        return $this->state(function (array $attributes) use ($skillUuid) {
            return [
                'skill_uuid' => $skillUuid,
            ];
        });
    }
}
