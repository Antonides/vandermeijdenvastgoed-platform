<?php

namespace App\Filament\Resources\Contacts\Tables;

use App\Models\Contact;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ContactsTable
{
    public static function configure(Table $table): Table
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

                TextColumn::make('projects_count')
                    ->label('# Projecten')
                    ->counts('projects')
                    ->badge()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Aangemaakt op')
                    ->dateTime('d-m-Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('party')
                    ->label('Partij')
                    ->options(fn () => Contact::query()
                        ->select('party')
                        ->distinct()
                        ->whereNotNull('party')
                        ->orderBy('party')
                        ->pluck('party', 'party')
                    ),

                Filter::make('project')
                    ->form([
                        \Filament\Forms\Components\Select::make('project_id')
                            ->label('Project')
                            ->relationship('projects', 'title')
                            ->searchable()
                            ->preload()
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->city}, {$record->street}"),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->when(
                            $data['project_id'],
                            fn ($q) => $q->whereHas('projects',
                                fn ($q) => $q->where('projects.id', $data['project_id'])
                            )
                        );
                    }),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
