<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Filament\Resources\Contacts\Schemas\ContactForm;
use Filament\Actions\AttachAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DetachAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContactsRelationManager extends RelationManager
{
    protected static string $relationship = 'contacts';

    protected static ?string $title = 'Contactpersonen';

    public function form(Schema $schema): Schema
    {
        return ContactForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('party')
                    ->label('Partij')
                    ->searchable()
                    ->sortable()
                    ->placeholder('—'),

                TextColumn::make('name')
                    ->label('Naam')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('function')
                    ->label('Functie')
                    ->searchable()
                    ->placeholder('—'),

                TextColumn::make('phone')
                    ->label('Telefoonnummer')
                    ->searchable()
                    ->icon('heroicon-o-phone')
                    ->copyable(),

                TextColumn::make('email')
                    ->label('E-mailadres')
                    ->searchable()
                    ->icon('heroicon-o-envelope')
                    ->copyable(),
            ])
            ->defaultSort('name', 'asc')
            ->headerActions([
                CreateAction::make()
                    ->label('Nieuw contact'),
                AttachAction::make()
                    ->label('Koppel bestaand contact')
                    ->preloadRecordSelect(),
            ])
            ->recordActions([
                EditAction::make(),
                DetachAction::make()
                    ->label('Ontkoppel'),
                DeleteAction::make(),
            ]);
    }
}
