<?php

namespace Database\Seeders;

use App\Models\ExamCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExamCategorySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Backend', 'slug' => 'backend'],
            ['name' => 'Frontend', 'slug' => 'frontend'],
            ['name' => 'Banco de Dados', 'slug' => 'banco-de-dados'],
            ['name' => 'DevOps', 'slug' => 'devops'],
            ['name' => 'Cloud', 'slug' => 'cloud'],
            ['name' => 'Mobile', 'slug' => 'mobile'],
        ];

        foreach ($categories as $category) {
            ExamCategory::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
