<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Widgets\Widget;

class ActiveProjectsWidget extends Widget
{
    protected static ?int $sort = 1;

    protected string $view = 'filament.widgets.active-projects-widget';

    protected int|string|array $columnSpan = 'full';

    protected ?string $heading = '';

    public function getActiveProjects()
    {
        return Project::where('project_status', 'lopend')
            ->orderBy('city')
            ->orderBy('street')
            ->get()
            ->map(function ($project) {
                $parts = array_filter([
                    $project->city,
                    $project->street,
                ]);
                $title = implode(', ', $parts) ?: '-';

                return [
                    'id' => $project->id,
                    'title' => $title,
                    'build_status' => $project->build_status,
                    'progress' => $this->calculateProgress($project->build_status),
                ];
            });
    }

    protected function calculateProgress(?string $buildStatus): int
    {
        return match ($buildStatus) {
            'concept' => 0,
            'start_bouw' => 9,
            'start_fundering' => 18,
            'start_begane_grondvloer' => 27,
            'verdiepingsvloer_gereed' => 36,
            'start_eerste_verdiepingsvloer' => 45,
            'dakvloer_gereed' => 54,
            'start_gevelbekleding' => 63,
            'wind_en_waterdicht' => 72,
            'oplevering' => 81,
            'sleuteloverdracht' => 100,
            default => 0,
        };
    }

    protected function getBuildStatusLabel(?string $buildStatus): string
    {
        return match ($buildStatus) {
            'concept' => 'Concept',
            'start_bouw' => 'Start bouw',
            'start_fundering' => 'Start fundering',
            'start_begane_grondvloer' => 'Start begane grondvloer',
            'verdiepingsvloer_gereed' => 'Verdiepingsvloer gereed',
            'start_eerste_verdiepingsvloer' => 'Start eerste verdiepingsvloer',
            'dakvloer_gereed' => 'Dakvloer gereed',
            'start_gevelbekleding' => 'Start gevelbekleding',
            'wind_en_waterdicht' => 'Wind- en waterdicht',
            'oplevering' => 'Oplevering',
            'sleuteloverdracht' => 'Sleuteloverdracht',
            default => 'Onbekend',
        };
    }
}
