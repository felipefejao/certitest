<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::transaction(function () {
            $duplicates = DB::table('answers')
                ->select('attempt_id', 'question_id', DB::raw('MAX(id) as keep_id'))
                ->groupBy('attempt_id', 'question_id')
                ->havingRaw('COUNT(*) > 1')
                ->get();

            foreach ($duplicates as $duplicate) {
                DB::table('answers')
                    ->where('attempt_id', $duplicate->attempt_id)
                    ->where('question_id', $duplicate->question_id)
                    ->where('id', '<', $duplicate->keep_id)
                    ->delete();
            }
        });

        Schema::table('answers', function (Blueprint $table) {
            $table->unique(['attempt_id', 'question_id']);
        });

        Schema::table('attempts', function (Blueprint $table) {
            $table->index(['user_id', 'exam_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attempts', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'exam_id']);
        });

        Schema::table('answers', function (Blueprint $table) {
            $table->dropUnique(['attempt_id', 'question_id']);
        });
    }
};
