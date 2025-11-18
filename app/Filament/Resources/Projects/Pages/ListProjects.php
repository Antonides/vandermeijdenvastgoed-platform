<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use App\Models\Project;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListProjects extends ListRecords
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'alle' => Tab::make('Alle projecten')
                ->badge(Project::query()->count()),
            'lopend' => Tab::make('Lopend')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('project_status', 'lopend'))
                ->badge(Project::query()->where('project_status', 'lopend')->count())
                ->badgeColor('warning'),
            'ingepland' => Tab::make('Ingepland')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('project_status', 'ingepland'))
                ->badge(Project::query()->where('project_status', 'ingepland')->count())
                ->badgeColor('info'),
            'afgerond' => Tab::make('Afgerond')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('project_status', 'afgerond'))
                ->badge(Project::query()->where('project_status', 'afgerond')->count())
                ->badgeColor('success'),
        ];
    }
}
