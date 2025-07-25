<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skill;
use App\Models\Learning;

class FixLearningSkillSeeder extends Seeder
{
    public function run()
    {
        // Ambil semua skill
        $skills = Skill::all();
        // Update semua learning yang belum punya skill_id, berdasarkan nama category
        foreach (Learning::whereNull('skill_id')->get() as $learning) {
            $skill = $skills->firstWhere('name', $learning->category);
            if ($skill) {
                $learning->skill_id = $skill->id;
                $learning->save();
            }
        }
    }
}
