<?php

namespace App\Filament\Resources\WorkPreparations\Tables;

use App\Models\WorkPreparation;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class WorkPreparationsTable
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
                TextColumn::make('component')
                    ->label('Onderdeel')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('request_date')
                    ->label('Aanvraag')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('planned_date')
                    ->label('Planning')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('received_date')
                    ->label('Ontvangst')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('party')
                    ->label('Partij')
                    ->toggleable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        WorkPreparation::STATUS_ACTION => 'Actie',
                        WorkPreparation::STATUS_IN_PROGRESS => 'Lopend',
                        WorkPreparation::STATUS_COMPLETED => 'Afgerond',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state) => match ($state) {
                        WorkPreparation::STATUS_COMPLETED => 'success',
                        WorkPreparation::STATUS_IN_PROGRESS => 'info',
                        default => 'warning',
                    })
                    ->sortable(),
                TextColumn::make('note')
                    ->label('Notitie')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),
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
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        WorkPreparation::STATUS_ACTION => 'Actie',
                        WorkPreparation::STATUS_IN_PROGRESS => 'Lopend',
                        WorkPreparation::STATUS_COMPLETED => 'Afgerond',
                    ]),
                TernaryFilter::make('received_date')
                    ->label('Ontvangen')
                    ->placeholder('Alle records')
                    ->trueLabel('Met ontvangst')
                    ->falseLabel('Zonder ontvangst')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('received_date'),
                        false: fn ($query) => $query->whereNull('received_date'),
                        blank: fn ($query) => $query,
                    ),
            ])
            ->defaultSort('planned_date', 'asc')
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
