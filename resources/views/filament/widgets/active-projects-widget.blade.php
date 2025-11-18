<x-filament-widgets::widget>
    <x-filament::section>
        @php
            $projects = $this->getActiveProjects();
        @endphp

        @if($projects->isEmpty())
            <div class="text-sm text-gray-500 dark:text-gray-400 py-4">
                Geen lopende projecten
            </div>
        @else
            <div class="space-y-6 py-2">
                @foreach($projects as $project)
                    <a 
                        href="{{ \App\Filament\Resources\Projects\ProjectResource::getUrl('edit', ['record' => $project['id']]) }}"
                        style="display: block; margin-bottom: 24px; text-decoration: none; cursor: pointer; transition: opacity 0.2s ease;"
                        onmouseover="this.style.opacity='0.8'"
                        onmouseout="this.style.opacity='1'"
                    >
                        {{-- Project titel en status --}}
                        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 8px;">
                            <span style="font-size: 0.875rem; font-weight: 500; color: #111827;">
                                {{ $project['title'] }}
                            </span>
                            <span style="font-size: 0.875rem; font-weight: 600; color: #34868c; text-align: right; white-space: nowrap; margin-left: 16px;">
                                {{ $this->getBuildStatusLabel($project['build_status']) }}
                            </span>
                        </div>

                        {{-- Progress bar --}}
                        <div style="width: 100%; height: 10px; background-color: #e5e7eb; border-radius: 9999px; overflow: hidden;">
                            @if($project['progress'] > 0)
                                <div 
                                    style="height: 10px; width: {{ $project['progress'] }}%; background-color: #34868c; transition: width 0.3s ease;"
                                    title="{{ $project['progress'] }}%"
                                >&nbsp;</div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
