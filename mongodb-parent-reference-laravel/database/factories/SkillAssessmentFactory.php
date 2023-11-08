<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SkillAssessment>
 */
class SkillAssessmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'is_approved' => $this->faker->boolean,
            'assessed_at' => $this->faker->iso8601,
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

    public function teacher(Teacher $teacher): Factory
    {
        return $this->state(function (array $attributes) use ($teacher) {
            return [
                'teacher_id' => $teacher->id,
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
