<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Filament\Resources\WorkPreparations\Schemas\WorkPreparationForm;
use App\Models\WorkPreparation;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WorkPreparationsRelationManager extends RelationManager
{
    protected static string $relationship = 'workPreparations';

    protected static ?string $title = 'Werkvoorbereiding';

    public function form(Schema $schema): Schema
    {
        return WorkPreparationForm::configure($schema, includeProjectField: false);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('component')
                    ->label('Onderdeel')
                    ->sortable(),
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
                        WorkPreparation::STATUS_ACTION => 'warning',
                        default => 'secondary',
                    })
                    ->sortable(),
                TextColumn::make('party')
                    ->label('Partij')
                    ->toggleable(),
                TextColumn::make('note')
                    ->label('Notitie')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('component', 'asc')
            ->headerActions([
                CreateAction::make()
                    ->label('Nieuwe werkvoorbereiding')
                    ->modalHeading('Werkvoorbereiding toevoegen'),
            ])
            ->recordActions([
                EditAction::make()
                    ->modalHeading('Werkvoorbereiding bewerken'),
                DeleteAction::make(),
            ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['project_id'] = $this->getOwnerRecord()->getKey();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['project_id'] = $this->getOwnerRecord()->getKey();

        return $data;
    }
}
