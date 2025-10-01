<?php

namespace App\Filament\Resources\ProjectNotes\Pages;

use App\Filament\Resources\ProjectNotes\ProjectNoteResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateProjectNote extends CreateRecord
{
    protected static string $resource = ProjectNoteResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = $data['user_id'] ?? Auth::id();

        return $data;
    }
}
