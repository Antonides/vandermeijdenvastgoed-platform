<?php

namespace App\Filament\Resources\ProjectNotes\Pages;

use App\Filament\Resources\ProjectNotes\ProjectNoteResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditProjectNote extends EditRecord
{
    protected static string $resource = ProjectNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['user_id'] = $this->record->user_id ?? Auth::id();

        return $data;
    }
}
