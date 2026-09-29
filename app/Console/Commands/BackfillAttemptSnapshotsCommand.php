<?php

namespace App\Console\Commands;

use App\Models\Attempt;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

#[Signature('certitest:backfill-snapshots {--dry-run : Show what would be backfilled without writing}')]
#[Description('Backfill questions_snapshot for attempts created before snapshots existed')]
class BackfillAttemptSnapshotsCommand extends Command
{
    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');

        $filled = 0;
        $skipped = 0;

        Attempt::whereNull('questions_snapshot')
            ->with('exam', 'answers')
            ->chunkById(200, function ($attempts) use ($dryRun, &$filled, &$skipped) {
                foreach ($attempts as $attempt) {
                    $examQuestionIds = collect($attempt->exam?->questions ?? [])->pluck('id')->flip();

                    $consistent = $attempt->answers->every(
                        fn ($answer) => isset($examQuestionIds[$answer->question_id])
                    );

                    if (! $consistent || $examQuestionIds->isEmpty()) {
                        $skipped++;
                        Log::info('certitest:backfill-snapshots skipped attempt', ['attempt_id' => $attempt->id]);
                        $this->warn("Skipped attempt {$attempt->id}: answers do not match the current exam questions.");

                        continue;
                    }

                    if ($dryRun) {
                        $this->line("Would backfill attempt {$attempt->id}.");
                    } else {
                        $attempt->update(['questions_snapshot' => $attempt->exam->questions]);
                    }

                    $filled++;
                }
            });

        $this->info(($dryRun ? '[dry-run] ' : '')."Backfilled {$filled} attempt(s), skipped {$skipped}.");

        return self::SUCCESS;
    }
}
