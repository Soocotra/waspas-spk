<x-app-layout>
    <x-slot name="header" class="flex flex-row">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('History') }}
        </h2>
    </x-slot>
    <div>
        @livewire('history')
    </div>
</x-app-layout>
