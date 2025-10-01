<?php

namespace App\Filament\Resources\ProjectNotes\Tables;

use App\Models\ProjectNote;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProjectNotesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Titel')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('project.title')
                    ->label('Project')
                    ->placeholder('—')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        ProjectNote::STATUS_ACTION => 'Actie',
                        ProjectNote::STATUS_IN_PROGRESS => 'Lopend',
                        ProjectNote::STATUS_COMPLETED => 'Afgerond',
                        ProjectNote::STATUS_INFO => 'Informatief',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state) => match ($state) {
                        ProjectNote::STATUS_ACTION => 'warning',
                        ProjectNote::STATUS_IN_PROGRESS => 'info',
                        ProjectNote::STATUS_COMPLETED => 'success',
                        ProjectNote::STATUS_INFO => 'secondary',
                        default => 'secondary',
                    })
                    ->sortable(),
                TextColumn::make('reminder_at')
                    ->label('Herinnering')
                    ->dateTime('d-m-Y H:i')
                    ->placeholder('—')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('user.name')
                    ->label('Aangemaakt door')
                    ->placeholder('Onbekend')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Aangemaakt op')
                    ->dateTime('d-m-Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        ProjectNote::STATUS_ACTION => 'Actie',
                        ProjectNote::STATUS_IN_PROGRESS => 'Lopend',
                        ProjectNote::STATUS_COMPLETED => 'Afgerond',
                        ProjectNote::STATUS_INFO => 'Informatief',
                    ]),
                TernaryFilter::make('reminder')
                    ->label('Met herinnering')
                    ->placeholder('Alle notities')
                    ->trueLabel('Alleen met herinnering')
                    ->falseLabel('Zonder herinnering')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('reminder_at'),
                        false: fn ($query) => $query->whereNull('reminder_at'),
                        blank: fn ($query) => $query,
                    ),
            ])
            ->defaultSort('reminder_at', 'asc')
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
