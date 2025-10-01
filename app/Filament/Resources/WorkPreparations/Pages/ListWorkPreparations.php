<?php

namespace App\Filament\Resources\WorkPreparations\Pages;

use App\Filament\Resources\WorkPreparations\WorkPreparationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWorkPreparations extends ListRecords
{
    protected static string $resource = WorkPreparationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
