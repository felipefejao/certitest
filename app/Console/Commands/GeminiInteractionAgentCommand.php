<?php

namespace App\Console\Commands;

use App\Services\GeminiService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:gemini-interaction-agent-command')]
#[Description('Make a question to Gemini First Agent')]
class GeminiInteractionAgentCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $agent = new GeminiService;
        $question = $this->input('question', 'What is the capital of France?');
        $answer = $agent->makeAQuestion($question);

        dd($answer);

        $this->info($answer);
    }
}
