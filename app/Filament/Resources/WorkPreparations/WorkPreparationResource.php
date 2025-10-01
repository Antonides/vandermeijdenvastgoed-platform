<?php

namespace App\Filament\Resources\WorkPreparations;

use App\Filament\Resources\WorkPreparations\Pages\CreateWorkPreparation;
use App\Filament\Resources\WorkPreparations\Pages\EditWorkPreparation;
use App\Filament\Resources\WorkPreparations\Pages\ListWorkPreparations;
use App\Filament\Resources\WorkPreparations\Schemas\WorkPreparationForm;
use App\Filament\Resources\WorkPreparations\Tables\WorkPreparationsTable;
use App\Models\WorkPreparation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class WorkPreparationResource extends Resource
{
    protected static ?string $model = WorkPreparation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $navigationLabel = 'Werkvoorbereiding';

    protected static ?string $modelLabel = 'Werkvoorbereiding';

    protected static ?string $pluralModelLabel = 'Werkvoorbereidingen';

    protected static string|UnitEnum|null $navigationGroup = 'Werkvoorbereiding';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'component';

    public static function form(Schema $schema): Schema
    {
        return WorkPreparationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WorkPreparationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWorkPreparations::route('/'),
            'create' => CreateWorkPreparation::route('/create'),
            'edit' => EditWorkPreparation::route('/{record}/edit'),
        ];
    }
}
