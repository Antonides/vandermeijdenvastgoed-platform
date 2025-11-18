<?php

namespace App\Filament\Resources\ProjectNotes;

use App\Filament\Resources\ProjectNotes\Pages\CreateProjectNote;
use App\Filament\Resources\ProjectNotes\Pages\EditProjectNote;
use App\Filament\Resources\ProjectNotes\Pages\ListProjectNotes;
use App\Filament\Resources\ProjectNotes\RelationManagers\RepliesRelationManager;
use App\Filament\Resources\ProjectNotes\Schemas\ProjectNoteForm;
use App\Filament\Resources\ProjectNotes\Tables\ProjectNotesTable;
use App\Models\ProjectNote;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ProjectNoteResource extends Resource
{
    protected static ?string $model = ProjectNote::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $modelLabel = 'Notitie';

    protected static ?string $pluralModelLabel = 'Notities';

    protected static ?string $navigationLabel = 'Notities';

    protected static string|UnitEnum|null $navigationGroup = 'Projectbeheer';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return ProjectNoteForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProjectNotesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RepliesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProjectNotes::route('/'),
            'create' => CreateProjectNote::route('/create'),
            'edit' => EditProjectNote::route('/{record}/edit'),
        ];
    }
}
