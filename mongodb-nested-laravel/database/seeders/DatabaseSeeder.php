<?php

namespace Database\Seeders;

use App\Models\SkillAssessment;
use App\Models\SkillEvidence;
use App\Models\Skilltree;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $teacherOne = Teacher::factory()->create();
        $teacherTwo = Teacher::factory()->create();

        $students = Student::factory()
            ->count(3)
            ->create();

        $skilltrees = Skilltree::factory()
            ->count(2)
            ->skills(3)
            ->create();

        $teacherOne->skilltrees = [
            $skilltrees->first()->id
        ];
        $teacherOne->save();

        $studentOne = $students->first();
        $studentOne->skilltrees = [
            $skilltrees->first()->id
        ];
        $studentOne->save();

        $skillEvidence = SkillEvidence::factory()
            ->student($studentOne)
            ->skill($skilltrees->first()['skills'][0]['skills'][0]['uuid'])
            ->create();

        $skillAssessment = SkillAssessment::factory()
            ->teacher($teacherOne)
            ->skill($skilltrees->first()['skills'][0]['skills'][0]['uuid'])
            ->create();


        $teacherTwo->skilltrees = [
            $skilltrees->get(1)->id
        ];
        $teacherTwo->save();
        $studentTwo = $students->get(1);
        $studentTwo->skilltrees = [
            $skilltrees->first()->id,
            $skilltrees->get(1)->id,
        ];
        $studentTwo->save();


    }
}
