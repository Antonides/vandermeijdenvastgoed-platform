<div class="flex flex-row items-center gap-1.5 px-3 py-2">
    <span class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">Week {{ now()->format('W') }}</span>
    <x-filament::icon 
        icon="heroicon-o-calendar" 
        class="h-4 w-4 text-gray-500 dark:text-gray-400 flex-shrink-0"
    />
</div>
