<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Filament\Resources\ProjectNotes\Schemas\ProjectNoteForm;
use App\Models\ProjectNote;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class NotesRelationManager extends RelationManager
{
    protected static string $relationship = 'notes';

    protected static ?string $title = 'Notities';

    public function form(Schema $schema): Schema
    {
        return ProjectNoteForm::configure($schema, includeProjectField: false);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Titel')
                    ->searchable()
                    ->sortable(),
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
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Aangemaakt door')
                    ->placeholder('Onbekend')
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Aangemaakt op')
                    ->dateTime('d-m-Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->headerActions([
                CreateAction::make()
                    ->label('Nieuwe notitie'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['project_id'] = $this->getOwnerRecord()->getKey();
        $data['user_id'] = $data['user_id'] ?? Auth::id();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['project_id'] = $this->getOwnerRecord()->getKey();
        $data['user_id'] = $this->record->user_id ?? Auth::id();

        return $data;
    }
}
