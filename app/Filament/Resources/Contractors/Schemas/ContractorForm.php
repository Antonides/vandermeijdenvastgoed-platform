<?php

namespace App\Filament\Resources\Contractors\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContractorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Contractor')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('company_name')
                            ->label('Bedrijfsnaam')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),
                        TextInput::make('contact_person')
                            ->label('Contactpersoon')
                            ->maxLength(255)
                            ->columnSpan(1),
                        TextInput::make('phone')
                            ->label('Telefoon')
                            ->tel()
                            ->rule('regex:/^(\+|00)?[0-9\s().-]{6,20}$/')
                            ->maxLength(255)
                            ->columnSpan(1),
                        TextInput::make('email')
                            ->label('E-mail')
                            ->email()
                            ->rules(['nullable', 'email'])
                            ->maxLength(255)
                            ->columnSpan(1),
                        Select::make('specialization')
                            ->label('Specialisatie')
                            ->options([
                                'demolition' => 'Sloop',
                                'construction' => 'Bouw',
                                'both' => 'Beide',
                            ])
                            ->searchable()
                            ->nullable()
                            ->columnSpanFull(),
                    ]),
                Section::make('Adres')
                    ->columns(4)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('street')
                            ->label('Straat')
                            ->maxLength(255)
                            ->columnSpan(2),
                        TextInput::make('house_number')
                            ->label('Huisnummer')
                            ->maxLength(20)
                            ->columnSpan(1),
                        TextInput::make('postal_code')
                            ->label('Postcode')
                            ->maxLength(20)
                            ->columnSpan(1),
                        TextInput::make('city')
                            ->label('Plaats')
                            ->maxLength(255)
                            ->columnSpan(2),
                    ]),
            ]);
    }
}
