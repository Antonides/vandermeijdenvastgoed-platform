<?php

namespace App\Filament\Resources\Contacts\Schemas;

use App\Models\Contact;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Contactgegevens')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('party')
                            ->label('Partij')
                            ->maxLength(255)
                            ->columnSpanFull(),

                        TextInput::make('name')
                            ->label('Naam')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('function')
                            ->label('Functie')
                            ->maxLength(255),

                        TextInput::make('phone')
                            ->label('Telefoonnummer')
                            ->tel()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('E-mailadres')
                            ->email()
                            ->maxLength(255),
                    ]),

                Section::make('Gekoppelde Projecten')
                    ->description('Koppel dit contact aan één of meerdere projecten')
                    ->columnSpanFull()
                    ->schema([
                        Select::make('projects')
                            ->label('Projecten')
                            ->multiple()
                            ->relationship('projects', 'title')
                            ->searchable()
                            ->preload()
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->city}, {$record->street}")
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
