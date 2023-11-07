<?php

namespace Database\Seeders;

use App\Models\Skill;
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

        $students = Student::factory()
            ->create();

        $skilltree = Skilltree::factory()
//            ->skills(3)
            ->create();

        $skillOne = Skill::factory()
            ->create([
                'skilltree_id' => $skilltree->id,
            ]);

        $skillTwo = Skill::factory()
            ->create([
                'ancestors' => [
                    $skillOne->id
                ],
                'parent' => $skillOne->id,
            ]);
        $skillThree = Skill::factory()
            ->create([
                'ancestors' => [
                    $skillOne->id,
                    $skillTwo->id,
                ],
                'parent' => $skillTwo->id,
            ]);


//        $teacherOne->skilltrees = [
//            $skilltree->id
//        ];
//        $teacherOne->save();
//
//        $studentOne = $students->first();
//        $studentOne->skilltrees = [
//            $skilltree->id
//        ];
//        $studentOne->save();
//
//        $skillEvidence = SkillEvidence::factory()
//            ->student($studentOne)
//            ->skill($skilltree['skills'][0]['skills'][0]['uuid'])
//            ->create();
//
//        $skillAssessment = SkillAssessment::factory()
//            ->teacher($teacherOne)
//            ->skill($skilltree['skills'][0]['skills'][0]['uuid'])
//            ->create();
    }
}
