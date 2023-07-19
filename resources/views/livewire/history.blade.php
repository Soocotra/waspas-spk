<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-button wire:click="openModal" class="mb-2" rightIcon="plus" positive label="Tambah Kasus"
                spinner="openModal" />
            @livewire('project-table')
        </div>
    </div>
    <x-modal wire:model.defer="simpleModal">
        <x-card title="Tambah Kasus" fullscreen="true">
            <x-input wire:model="projectName" right-icon="cube" label="Nama Kasus"
                placeholder="Contoh: Pemilihan Ketua Kelas" />
            {{-- <x-error name="projectName" /> --}}
            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Cancel" x-on:click="close" />
                    <x-button positive label="Simpan" wire:click.prevent="saveProject" />
                </div>
            </x-slot>
        </x-card>
    </x-modal>
</div>
