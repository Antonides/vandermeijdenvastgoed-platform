<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function components(): array
    {
        return [
            Section::make('Projectgegevens')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    TextInput::make('title')
                        ->label('Titel')
                        ->maxLength(255)
                        ->columnSpanFull(),
                    Textarea::make('description')
                        ->label('Beschrijving')
                ->rows(3)
                        ->columnSpanFull(),
                    Select::make('status')
                        ->label('Bouwtermijn')
                        ->options([
                            'concept' => 'Concept',
                            'start_bouw' => 'Start bouw',
                            'start_fundering' => 'Start fundering',
                            'start_begane_grondvloer' => 'Start begane grondvloer',
                            'verdiepingsvloer_gereed' => 'Verdiepingsvloer gereed',
                            'start_eerste_verdiepingsvloer' => 'Start eerste verdiepingsvloer',
                            'dakvloer_gereed' => 'Dakvloer gereed',
                            'start_gevelbekleding' => 'Start gevelbekleding',
                            'wind_en_waterdicht' => 'Wind- en waterdicht',
                            'oplevering' => 'Oplevering',
                            'sleuteloverdracht' => 'Sleuteloverdracht',
                        ])
                        ->default('concept')
                        ->searchable()
                        ->native(false),
                    Select::make('permit')
                        ->label('Vergunning')
                        ->options([
                            'aangevraagd' => 'Aangevraagd',
                            'verleend' => 'Verleend',
                            'afgewezen' => 'Afgewezen',
                        ])
                        ->native(false)
                        ->searchable(),
                    DatePicker::make('start_build_date')
                        ->label('Start bouwdatum')
                        ->native(false),
                    DatePicker::make('completion_date')
                        ->label('Opleverdatum')
                        ->native(false),
                ]),
            Section::make('Locatie')
                ->columns(3)
                ->columnSpanFull()
                ->schema([
                    TextInput::make('city')
                        ->label('Plaats')
                        ->maxLength(255),
                    TextInput::make('street')
                        ->label('Straat')
                        ->maxLength(255),
                    TextInput::make('house_number')
                        ->label('Huisnummer')
                        ->maxLength(255),
                ]),
            Section::make('Aannemers')
                ->columns(2)
                ->columnSpanFull()
                ->schema([
                    Select::make('demolition_contractor_id')
                        ->label('Sloopaannemer')
                        ->relationship('demolitionContractor', 'company_name')
                        ->searchable()
                        ->preload()
                        ->native(false),
                    Select::make('build_contractor_id')
                        ->label('Bouwaannemer')
                        ->relationship('buildContractor', 'company_name')
                        ->searchable()
                        ->preload()
                        ->native(false),
                ]),
        ];
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components(self::components());
    }
}
