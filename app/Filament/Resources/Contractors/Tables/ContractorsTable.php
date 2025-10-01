<?php

namespace App\Filament\Resources\Contractors\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContractorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company_name')
                    ->label('Bedrijfsnaam')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('contact_person')
                    ->label('Contactpersoon')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('phone')
                    ->label('Telefoon')
                    ->toggleable(),
                TextColumn::make('email')
                    ->label('E-mail')
                    ->toggleable(),
                TextColumn::make('specialization')
                    ->label('Specialisatie')
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'demolition' => 'Sloop',
                        'construction' => 'Bouw',
                        'both' => 'Beide',
                        default => null,
                    })
                    ->placeholder('—')
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Aangemaakt op')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
