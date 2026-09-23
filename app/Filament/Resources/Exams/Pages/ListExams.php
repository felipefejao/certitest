<?php

namespace App\Filament\Resources\Exams\Pages;

use App\Filament\Resources\Exams\ExamResource;
use App\Models\Exam;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;

class ListExams extends ListRecords
{
    protected static string $resource = ExamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),

            Action::make('importJson')
                ->label('Importar JSON')
                ->icon('heroicon-m-arrow-down-tray')
                ->color('warning')
                ->form([
                    FileUpload::make('file')
                        ->label('Arquivo JSON')
                        ->acceptedFileTypes(['application/json'])
                        ->required(),
                ])
                ->action(function (array $data): void {
                    $path = $data['file'];
                    $content = Storage::disk('local')->get($path);
                    $items = json_decode($content, true);

                    if (! is_array($items)) {
                        Notification::make()
                            ->title('Formato inválido')
                            ->body('O arquivo JSON deve conter um array de provas.')
                            ->danger()
                            ->send();

                        return;
                    }

                    $imported = 0;

                    foreach ($items as $item) {
                        $validated = $this->validateExamData($item);

                        if ($validated === null) {
                            continue;
                        }

                        Exam::updateOrCreate(
                            ['slug' => $validated['slug']],
                            $validated
                        );

                        $imported++;
                    }

                    Notification::make()
                        ->title('Importação concluída')
                        ->body("{$imported} prova(s) importada(s) com sucesso.")
                        ->success()
                        ->send();
                }),

            Action::make('exportJson')
                ->label('Exportar JSON')
                ->icon('heroicon-m-arrow-up-tray')
                ->color('success')
                ->url(route('exams.export'))
                ->openUrlInNewTab(false),
        ];
    }

    private function validateExamData(array $data): ?array
    {
        if (! isset($data['name'], $data['slug'], $data['questions']) || ! is_array($data['questions'])) {
            return null;
        }

        $status = $data['status'] ?? 'draft';

        if (! in_array($status, ['draft', 'published', 'inactive'], true)) {
            $status = 'draft';
        }

        $questions = [];

        foreach ($data['questions'] as $question) {
            if (! isset($question['question'], $question['options'], $question['correct_answer'])) {
                continue;
            }

            $questions[] = [
                'id' => $question['id'] ?? (string) str()->uuid(),
                'question' => $question['question'],
                'options' => [
                    'A' => $question['options']['A'] ?? '',
                    'B' => $question['options']['B'] ?? '',
                    'C' => $question['options']['C'] ?? '',
                    'D' => $question['options']['D'] ?? '',
                ],
                'correct_answer' => in_array($question['correct_answer'], ['A', 'B', 'C', 'D'], true)
                    ? $question['correct_answer']
                    : 'A',
            ];
        }

        if ($questions === []) {
            return null;
        }

        return [
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] ?? null,
            'status' => $status,
            'questions' => $questions,
        ];
    }
}
