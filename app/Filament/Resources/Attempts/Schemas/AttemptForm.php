<?php

namespace App\Filament\Resources\Attempts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AttemptForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user.name')
                    ->label('Candidato')
                    ->disabled(),

                TextInput::make('exam.name')
                    ->label('Prova')
                    ->disabled(),

                TextInput::make('total_questions')
                    ->label('Total de questões')
                    ->disabled(),

                TextInput::make('correct_answers')
                    ->label('Acertos')
                    ->disabled(),

                TextInput::make('wrong_answers')
                    ->label('Erros')
                    ->disabled(),

                TextInput::make('percentage')
                    ->label('Percentual')
                    ->suffix('%')
                    ->disabled(),

                TextInput::make('started_at')
                    ->label('Iniciado em')
                    ->disabled(),

                TextInput::make('finished_at')
                    ->label('Finalizado em')
                    ->disabled(),
            ]);
    }
}
