<?php

namespace App\Filament\Resources\Projects\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Titel')
                    ->getStateUsing(function ($record) {
                        $parts = array_filter([
                            $record->city,
                            $record->street,
                        ]);
                        return implode(', ', $parts) ?: '-';
                    })
                    ->searchable(query: function ($query, $search) {
                        return $query->where(function ($query) use ($search) {
                            $query->where('city', 'like', "%{$search}%")
                                ->orWhere('street', 'like', "%{$search}%");
                        });
                    })
                    ->sortable(query: function ($query, $direction) {
                        return $query->orderBy('city', $direction)
                            ->orderBy('street', $direction);
                    }),
                TextColumn::make('description')
                    ->label('Beschrijving')
                    ->limit(60)
                    ->toggleable(),
                TextColumn::make('project_status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'ingepland' => 'Gepland',
                        'lopend' => 'Lopend',
                        'afgerond' => 'Afgerond',
                        default => $state,
                    })
                    ->color(fn (?string $state) => match ($state) {
                        'ingepland' => 'warning',
                        'lopend' => 'info',
                        'afgerond' => 'success',
                        default => 'secondary',
                    })
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('build_status')
                    ->label('Bouwtermijn')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => match ($state) {
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
                        default => $state,
                    })
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('city')
                    ->label('Plaats')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('street')
                    ->label('Straat')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('house_number')
                    ->label('Nr.')
                    ->toggleable(),
                TextColumn::make('permit')
                    ->label('Vergunning')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'aangevraagd' => 'Aangevraagd',
                        'verleend' => 'Verleend',
                        'afgewezen' => 'Afgewezen',
                        default => $state,
                    })
                    ->color(fn (?string $state) => match ($state) {
                        'verleend' => 'success',
                        'afgewezen' => 'danger',
                        'aangevraagd' => 'warning',
                        default => 'secondary',
                    })
                    ->toggleable(),
                TextColumn::make('start_build_date')
                    ->label('Start bouw')
                    ->formatStateUsing(fn ($state) => $state ? \Carbon\Carbon::parse($state)->translatedFormat('F Y') : '-')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('completion_date')
                    ->label('Oplevering')
                    ->formatStateUsing(fn ($state) => $state ? \Carbon\Carbon::parse($state)->translatedFormat('F Y') : '-')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('demolitionContractor.company_name')
                    ->label('Sloopaannemer')
                    ->toggleable(),
                TextColumn::make('buildContractor.company_name')
                    ->label('Bouwaannemer')
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Aangemaakt op')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Bijgewerkt op')
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
