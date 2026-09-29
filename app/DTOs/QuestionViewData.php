<?php

namespace App\DTOs;

readonly class QuestionViewData
{
    /**
     * @param  array<string, string>  $options
     */
    public function __construct(
        public string $id,
        public string $question,
        public array $options,
    ) {}

    /**
     * @param  array{id: string, question: string, options: array<string, string>}  $question
     */
    public static function fromArray(array $question): self
    {
        return new self(
            id: $question['id'],
            question: $question['question'],
            options: $question['options'],
        );
    }
}
