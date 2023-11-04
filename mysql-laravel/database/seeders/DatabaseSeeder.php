<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\Skilltree;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $numberOfSkilltrees = 500_000;
        $numberOfSkilltrees = 50_000;

        Skilltree::factory()
            ->count($numberOfSkilltrees)
            ->create()
            ->each(function (Skilltree $skilltree) use (&$maxNumberOfSkillsPerSkilltree, &$numbersOfChildrens) {
                Skill::factory()
                    ->count(5)
                    ->create([
                        'skilltree_id' => $skilltree->id,
                    ])
                    ->each(function (Skill $skill) {
                        Skill::factory()
                            ->count(5)
                            ->create([
                                'parent_id' => $skill->id,
                            ])->each(function (Skill $skill) {
                                Skill::factory()
                                    ->count(5)
                                    ->create([
                                        'parent_id' => $skill->id,
                                    ])->each(function (Skill $skill) {
                                        Skill::factory()
                                            ->count(5)
                                            ->create([
                                                'parent_id' => $skill->id,
                                            ])->each(function (Skill $skill) {
                                                Skill::factory()
                                                    ->count(5)
                                                    ->create([
                                                        'parent_id' => $skill->id,
                                                    ]);
                                            });
                                    });;
                            });;
                    });
            });


//        $numberOfSkilltrees = 400_00;
//        $numbersOfChildrens = 3;
//        $maxNumberOfSkillsPerSkilltree = 50;
//
//
//        Skilltree::factory()
//            ->count($numberOfSkilltrees)
//            ->create()
//            ->each(function (Skilltree $skilltree) use (&$maxNumberOfSkillsPerSkilltree, &$numbersOfChildrens) {
//                $numberOfSkills = 0;
//                while ($numberOfSkills < $maxNumberOfSkillsPerSkilltree) {
//                    collect(range(1, $numbersOfChildrens))->each(function () use (&$maxNumberOfSkillsPerSkilltree, &$numbersOfChildrens) {
//
//                    });
//                }
//            });
    }
}
