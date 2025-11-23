<?php

namespace App\Filament\Resources\Tenders\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TenderForm
{
    public static function configure(Schema $schema, bool $includeProjectField = true): Schema
    {
        return $schema
            ->components([
                Section::make('Aanbesteding')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        ...($includeProjectField ? [
                            Select::make('project_id')
                                ->label('Project')
                                ->relationship('project', 'title')
                                ->getOptionLabelFromRecordUsing(fn ($record) => implode(', ', array_filter([$record->city, $record->street])) ?: '-')
                                ->searchable(['title', 'city', 'street'])
                                ->preload()
                                ->native(false)
                                ->required()
                                ->columnSpan(1),
                        ] : []),
                        Select::make('contractor_id')
                            ->label('Partij')
                            ->relationship('contractor', 'company_name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->nullable()
                            ->columnSpan(1),
                        Select::make('component')
                            ->label('Onderdeel')
                            ->options([
                                'Sloopwerkzaamheden' => 'Sloopwerkzaamheden',
                                'Nieuwbouw' => 'Nieuwbouw',
                            ])
                            ->required()
                            ->native(false)
                            ->columnSpan(1),
                        DatePicker::make('request_date')
                            ->label('Aanvraag')
                            ->native(false)
                            ->columnSpan(1),
                        DatePicker::make('planning_date')
                            ->label('Planning')
                            ->native(false)
                            ->columnSpan(1),
                        DatePicker::make('received_date')
                            ->label('Ontvangst')
                            ->native(false)
                            ->columnSpan(1),
                        TextInput::make('total_price')
                            ->label('Totaalprijs')
                            ->numeric()
                            ->prefix('€')
                            ->rules(['nullable', 'numeric', 'min:0'])
                            ->columnSpan(1),
                        Textarea::make('note')
                            ->label('Notitie')
                            ->rows(4)
                            ->columnSpanFull()
                            ->nullable(),
                    ]),
            ]);
    }
}
