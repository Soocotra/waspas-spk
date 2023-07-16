<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <div class="pb-4 bg-white dark:bg-gray-900">
                            <div class="relative my-2">
                                <x-button wire:click="openModal" outline positive label="Tambah kriteria pembanding"
                                    icon="plus" spinner="openModal" />
                            </div>
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3" style="text-align: center">
                                            Name
                                        </th>
                                        <th scope="col" class="px-6 py-3" style="text-align: center">
                                            Weight
                                        </th>
                                        <th scope="col" class="px-6 py-3" style="text-align: center">
                                            Type
                                        </th>
                                        <th scope="col" class="px-6 py-3" style="text-align: center">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($criterias->isNotEmpty())
                                        @foreach ($criterias as $criteria)
                                            <input type="hidden" value="{{ $criteria->id }}" wire:model='criteriaId'>

                                            <tr
                                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                <th scope="row"
                                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                                    style="text-align: center">
                                                    {{ $criteria->name }}
                                                </th>
                                                <td class="px-6 py-4" style="text-align: center">
                                                    {{ $criteria->weight }}
                                                </td>
                                                <td class="px-6 py-4" style="text-align: center">
                                                    {{ $criteria->type->name }}
                                                </td>

                                                <td class="px-6 py-4" style="text-align: center">
                                                    <button class="text-blue-600"
                                                        wire:click.prevent="editCriteria({{ $criteria }})">
                                                        Edit
                                                    </button>
                                                    <button class="text-red-600"
                                                        wire:click.prevent="deleteConfirm({{ $criteria }})">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="px-6 py-6 font-bold text-gray-900 whitespace-nowrap dark:text-white"
                                                colspan="4" align="center">
                                                Belum ada kriteria yang diinput
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-modal wire:model.defer="simpleModal">
        <x-card title="{{ $criteriaName != null ? 'Edit Kriteria' : 'Tambah Kriteria' }}">
            <x-input wire:model="criteriaName" right-icon="presentation-chart-line" label="Nama Kriteria" class="my-2"
                placeholder="Contoh: Tinggi badan" />
            <x-inputs.number wire:model="weight" label="Bobot" aria-placeholder="1-5" class="my-2" />
            <x-native-select label="Tipe kriteria" wire:model="type">
                @foreach ($types as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </x-native-select>

            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Cancel" x-on:click="close" />
                    <x-button primary label="Simpan"
                        wire:click.prevent="{{ $criteriaId != null ? 'putCriteria' : 'saveCriteria' }}" />
                </div>
            </x-slot>
        </x-card>
    </x-modal>
</div>
