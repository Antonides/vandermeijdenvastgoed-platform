<?php

namespace App\Filament\Resources\WorkPreparations\Schemas;

use App\Models\WorkPreparation;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WorkPreparationForm
{
    /**
     * @return array<int, \Filament\Forms\Components\Component>
     */
    public static function components(bool $includeProjectField = true): array
    {
        $fields = [];

        if ($includeProjectField) {
            $fields[] = Select::make('project_id')
                ->label('Project')
                ->relationship('project', 'title')
                ->searchable()
                ->preload()
                ->native(false)
                ->required()
                ->columnSpan(1);
        }

        $fields = array_merge($fields, [
            Select::make('component')
                ->label('Onderdeel')
                ->options(fn () => array_combine(WorkPreparation::COMPONENTS, WorkPreparation::COMPONENTS))
                ->searchable()
                ->required()
                ->native(false)
                ->columnSpan(1),
            DatePicker::make('request_date')
                ->label('Aanvraag')
                ->native(false)
                ->columnSpan(1),
            DatePicker::make('planned_date')
                ->label('Planning')
                ->native(false)
                ->columnSpan(1),
            DatePicker::make('received_date')
                ->label('Ontvangst')
                ->native(false)
                ->columnSpan(1),
            TextInput::make('party')
                ->label('Partij')
                ->maxLength(255)
                ->columnSpan(1),
            Select::make('status')
                ->label('Status')
                ->options([
                    WorkPreparation::STATUS_ACTION => 'Actie',
                    WorkPreparation::STATUS_IN_PROGRESS => 'Lopend',
                    WorkPreparation::STATUS_COMPLETED => 'Afgerond',
                ])
                ->default(WorkPreparation::STATUS_ACTION)
                ->required()
                ->native(false)
                ->columnSpan(1),
            Textarea::make('note')
                ->label('Notitie')
                ->rows(4)
                ->columnSpanFull(),
        ]);

        return [
            Section::make('Werkvoorbereiding')
                ->columns(2)
                ->columnSpanFull()
                ->schema($fields),
        ];
    }

    public static function configure(Schema $schema, bool $includeProjectField = true): Schema
    {
        return $schema->components(self::components($includeProjectField));
    }
}
