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
                    ->getStateUsing(fn ($record) => implode(', ', array_filter([$record->project->city, $record->project->street])) ?: '-')
                    ->searchable(query: function ($query, $search) {
                        $query->whereHas('project', function ($q) use ($search) {
                            $q->where('city', 'like', "%{$search}%")
                                ->orWhere('street', 'like', "%{$search}%");
                        });
                    })
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
                    ->date('d-m-Y')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('planning_date')
                    ->label('Planning')
                    ->date('d-m-Y')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('received_date')
                    ->label('Ontvangst')
                    ->date('d-m-Y')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('total_price')
                    ->label('Totaalprijs')
                    ->money('eur', true)
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('price_per_square_meter')
                    ->label('Meterprijs')
                    ->state(function ($record): ?string {
                        $pricePerM2 = $record->price_per_square_meter;

                        return $pricePerM2 ? '€ '.number_format($pricePerM2, 2, ',', '.').'/m²' : '-';
                    })
                    ->sortable(query: function ($query, string $direction) {
                        return $query
                            ->leftJoin('projects', 'tenders.project_id', '=', 'projects.id')
                            ->select('tenders.*')
                            ->selectRaw('
                                CASE
                                    WHEN tenders.component = "Nieuwbouw" AND projects.oppervlakte_begane_grond > 0
                                        THEN tenders.total_price / projects.oppervlakte_begane_grond
                                    WHEN tenders.component = "Sloopwerkzaamheden" AND projects.oppervlakte_perceel > 0
                                        THEN tenders.total_price / projects.oppervlakte_perceel
                                    ELSE NULL
                                END as calculated_price_per_m2
                            ')
                            ->orderBy('calculated_price_per_m2', $direction);
                    })
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
                    ->relationship('project', 'title', fn ($query) => $query->whereNotNull('title')),
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
