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
        $sections = [];

        if ($includeProjectField) {
            $sections[] = Select::make('project_id')
                ->label('Project')
                ->relationship('project', 'title')
                ->getOptionLabelFromRecordUsing(fn ($record) => implode(', ', array_filter([$record->city, $record->street])) ?: '-')
                ->searchable(['title', 'city', 'street'])
                ->preload()
                ->native(false)
                ->required()
                ->columnSpanFull();
        }

        // SECTIE 1: Werkvoorbereiding
        $sections[] = Section::make('Werkvoorbereiding')
            ->columns(2)
            ->columnSpanFull()
            ->schema([
                Select::make('component')
                    ->label('Onderdeel')
                    ->options(fn () => array_combine(WorkPreparation::COMPONENTS, WorkPreparation::COMPONENTS))
                    ->searchable()
                    ->required()
                    ->native(false)
                    ->allowHtml(false)
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label('Nieuw onderdeel')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Voer een nieuw werkvoorbereiding onderdeel in dat niet in de lijst staat.'),
                    ])
                    ->createOptionUsing(function (array $data): string {
                        return $data['name'];
                    })
                    ->getSearchResultsUsing(function (string $search) {
                        $options = array_combine(WorkPreparation::COMPONENTS, WorkPreparation::COMPONENTS);

                        return array_filter($options, fn ($option) => str_contains(strtolower($option), strtolower($search)));
                    })
                    ->getOptionLabelUsing(fn ($value): ?string => $value)
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
                Textarea::make('note')
                    ->label('Notitie')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);

        // SECTIE 2: Offerte
        $sections[] = Section::make('Offerte')
            ->columns(3)
            ->columnSpanFull()
            ->schema([
                DatePicker::make('quote_request_date')
                    ->label('Aanvraag')
                    ->native(false)
                    ->columnSpan(1),
                DatePicker::make('quote_received_date')
                    ->label('Ontvangst')
                    ->native(false)
                    ->columnSpan(1),
                DatePicker::make('quote_approved_date')
                    ->label('Akkoord')
                    ->native(false)
                    ->columnSpan(1),
            ]);

        // SECTIE 3: Uitvoering
        $sections[] = Section::make('Uitvoering')
            ->columns(2)
            ->columnSpanFull()
            ->schema([
                DatePicker::make('execution_date')
                    ->label('Uitvoering')
                    ->native(false)
                    ->columnSpan(1),
                DatePicker::make('execution_received_date')
                    ->label('Voltooid')
                    ->native(false)
                    ->columnSpan(1),
            ]);

        return $sections;
    }

    public static function configure(Schema $schema, bool $includeProjectField = true): Schema
    {
        return $schema->components(self::components($includeProjectField));
    }
}
