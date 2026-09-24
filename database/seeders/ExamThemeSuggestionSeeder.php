<?php

namespace Database\Seeders;

use App\Models\ExamThemeSuggestion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExamThemeSuggestionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExamThemeSuggestion::factory()->count(5)->create();
    }
}
