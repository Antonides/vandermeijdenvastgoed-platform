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
                TextColumn::make('component')
                    ->label('Onderdeel')
                    ->sortable(),
                TextColumn::make('contractor.company_name')
                    ->label('Partij')
                    ->sortable(),
                TextColumn::make('request_date')
                    ->label('Aanvraag')
                    ->date('d-m-Y')
                    ->sortable(),
                TextColumn::make('planning_date')
                    ->label('Planning')
                    ->date('d-m-Y')
                    ->sortable(),
                TextColumn::make('received_date')
                    ->label('Ontvangst')
                    ->date('d-m-Y')
                    ->sortable(),
                TextColumn::make('total_price')
                    ->label('Totaalprijs')
                    ->money('eur', true)
                    ->sortable(),
                TextColumn::make('price_per_square_meter')
                    ->label('Meterprijs')
                    ->state(function ($record): ?string {
                        $pricePerM2 = $record->price_per_square_meter;

                        return $pricePerM2 ? '€ '.number_format($pricePerM2, 2, ',', '.').'/m²' : '-';
                    })
                    ->sortable(false)
                    ->toggleable(),
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
