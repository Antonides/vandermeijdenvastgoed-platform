<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Filament\Resources\Tenders\Schemas\TenderForm;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TendersRelationManager extends RelationManager
{
    protected static string $relationship = 'tenders';

    protected static ?string $title = 'Aanbesteding';

    public function form(Schema $schema): Schema
    {
        return TenderForm::configure($schema, includeProjectField: false);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('contractor.company_name')
                    ->label('Partij')
                    ->sortable(),
                TextColumn::make('component')
                    ->label('Onderdeel')
                    ->sortable(),
                TextColumn::make('request_date')
                    ->label('Aanvraag')
                    ->date()
                    ->sortable(),
                TextColumn::make('received_date')
                    ->label('Ontvangst')
                    ->date()
                    ->sortable(),
                TextColumn::make('total_price')
                    ->label('Totaal prijs')
                    ->money('eur', true)
                    ->sortable(),
                TextColumn::make('note')
                    ->label('Notitie')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('request_date', 'desc')
            ->headerActions([
                CreateAction::make()
                    ->label('Nieuwe aanbesteding'),
            ])
            ->recordActions([
                EditAction::make(),
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
