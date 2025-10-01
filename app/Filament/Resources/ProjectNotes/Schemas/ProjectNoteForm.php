<?php

namespace App\Filament\Resources\ProjectNotes\Schemas;

use App\Models\ProjectNote;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProjectNoteForm
{
    public static function components(bool $includeProjectField = true): array
    {
        $components = [];

        if ($includeProjectField) {
            $components[] = Select::make('project_id')
                ->label('Project')
                ->relationship('project', 'title')
                ->searchable()
                ->preload()
                ->placeholder('Geen project')
                ->columnSpanFull();
        }

        return array_merge($components, [
            TextInput::make('title')
                ->label('Titel')
                ->required()
                ->maxLength(255),
            Select::make('status')
                ->label('Status')
                ->options([
                    ProjectNote::STATUS_ACTION => 'Actie',
                    ProjectNote::STATUS_IN_PROGRESS => 'Lopend',
                    ProjectNote::STATUS_COMPLETED => 'Afgerond',
                    ProjectNote::STATUS_INFO => 'Informatief',
                ])
                ->default(ProjectNote::STATUS_ACTION)
                ->required(),
            DateTimePicker::make('reminder_at')
                ->label('Herinnering op')
                ->seconds(false)
                ->nullable()
                ->rules(['nullable', 'after_or_equal:now'])
                ->native(false),
            Textarea::make('body')
                ->label('Notitie')
                ->required()
                ->rows(8)
                ->columnSpanFull(),
        ]);
    }

    public static function configure(Schema $schema, bool $includeProjectField = true): Schema
    {
        return $schema
            ->columns(2)
            ->components(self::components($includeProjectField));
    }
}
