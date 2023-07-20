<x-app-layout>
    <x-slot name="header" class="flex flex-row">
        @livewire('detail-case-header', ['project' => $project])
    </x-slot>
    <div>
        <livewire:config-project :projectId="$project->id" />
    </div>
    <div>
        <livewire:alternative :projectId="$project->id" />
    </div>

</x-app-layout>
