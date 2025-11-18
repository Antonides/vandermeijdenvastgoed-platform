<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProjectStatsOverview extends BaseWidget
{
    protected static ?int $sort = 0;
    
    protected int | string | array $columnSpan = 'full';
    
    protected function getStats(): array
    {
        return [
            Stat::make('Ingepland', Project::where('project_status', 'ingepland')->count())
                ->description('Projecten in planning')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('warning'),
            
            Stat::make('Lopend', Project::where('project_status', 'lopend')->count())
                ->description('Actieve projecten')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('info'),
            
            Stat::make('Afgerond', Project::where('project_status', 'afgerond')->count())
                ->description('Voltooide projecten')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
        ];
    }
}
