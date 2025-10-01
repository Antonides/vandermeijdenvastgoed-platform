<?php

namespace App\Filament\Resources\Tenders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class TendersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project.title')
                    ->label('Project')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('contractor.company_name')
                    ->label('Partij')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('component')
                    ->label('Onderdeel')
                    ->sortable(),
                TextColumn::make('request_date')
                    ->label('Aanvraag')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('received_date')
                    ->label('Ontvangst')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('total_price')
                    ->label('Totaal prijs')
                    ->money('eur', true)
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Aangemaakt op')
                    ->dateTime('d-m-Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('project')
                    ->label('Project')
                    ->relationship('project', 'title'),
                SelectFilter::make('contractor')
                    ->label('Partij')
                    ->relationship('contractor', 'company_name'),
                TernaryFilter::make('received')
                    ->label('Ontvangen')
                    ->placeholder('Alle')
                    ->trueLabel('Met ontvangst')
                    ->falseLabel('Zonder ontvangst')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('received_date'),
                        false: fn ($query) => $query->whereNull('received_date'),
                        blank: fn ($query) => $query,
                    ),
            ])
            ->defaultSort('request_date', 'desc')
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
