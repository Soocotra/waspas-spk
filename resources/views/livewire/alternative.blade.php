<div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <div class="pb-4 bg-white dark:bg-gray-900">
                        <div class="relative my-2">
                            <x-button wire:click="openModal" outline positive label="Tambah Alternatif" icon="plus"
                                spinner="openModal" />
                        </div>
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3" style="text-align: center">
                                        Name
                                    </th>
                                    {{-- <th scope="col" class="px-6 py-3" style="text-align: center">
                                            Status
                                        </th> --}}
                                    @foreach ($criterias as $criteria)
                                        <th scope="col" class="px-6 py-3" style="text-align: center">
                                            {{ $criteria->name }}
                                        </th>
                                    @endforeach
                                    <th scope="col" class="px-6 py-3" style="text-align: center">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($alternatives->isNotEmpty())
                                    @foreach ($alternatives as $alternative)
                                        <input type="hidden" value="{{ $alternative->id }}" wire:model='alternativeId'>

                                        <tr
                                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                                style="text-align: center">
                                                {{ $alternative->name }}
                                            </th>
                                            {{-- @if (App\Models\Criteria::where('project_id', $projectId)->count() == App\Models\AlternativeCriteria::where('alternative_id', $alternative->id)->count())
                                                    <td class="px-6 py-4 text-blue-500">
                                                        All set
                                                    </td>
                                                @else
                                                    <td class="px-6 py-4 text-red-500">
                                                        Missing criteria value
                                                    </td>
                                                @endif --}}
                                            @foreach ($criterias as $criteria)
                                                @if (App\Models\AlternativeCriteria::where('criteria_id', $criteria->id)->where('alternative_id', $alternative->id)->first() != null)
                                                    <th scope="col" class="px-6 py-4" style="text-align: center">
                                                        {{ App\Models\AlternativeCriteria::where('criteria_id', $criteria->id)->where('alternative_id', $alternative->id)->first()->value }}
                                                    </th>
                                                @else
                                                    <th scope="col" class="px-6 py-4 text-red-500"
                                                        style="text-align: center">
                                                        Not Set
                                                    </th>
                                                @endif
                                            @endforeach
                                            <td class="px-6 py-4" style="text-align: center">
                                                <button class="text-blue-600"
                                                    wire:click.prevent="editAlternative({{ $alternative }})">
                                                    Edit
                                                </button>
                                                <button class="text-red-600"
                                                    wire:click.prevent="deleteConfirm({{ $alternative }})">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="px-6 py-6 font-bold text-gray-900 whitespace-nowrap dark:text-white"
                                            colspan="{{ $criterias->count() + 4 }}" align="center">
                                            Belum ada Alternatif yang diinput
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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <div class="pb-4 bg-white dark:bg-gray-900">
                            <header class="bg-white shadow">
                                <div class="max-w-7xl mx-auto py-6 font-bold text-xl px-4 sm:px-6 lg:px-8"
                                    align="center">
                                    Peringkat Alternatif
                                </div>
                            </header>
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3" style="text-align: center">
                                            Name
                                        </th>
                                        <th scope="col" class="px-6 py-3" style="text-align: center">
                                            Nilai QI
                                        </th>
                                        <th scope="col" class="px-6 py-3" style="text-align: center">
                                            Peringkat
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($results != [])
                                        @foreach ($results as $key => $result)
                                            <tr
                                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                <th scope="row" style="text-align: center"
                                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ $result->alt }}
                                                </th>
                                                <td class="px-6 py-4" style="text-align: center">
                                                    {{ $result->qi }}
                                                </td>
                                                <td class="px-6 py-3" style="text-align: center">
                                                    {{ $key + 1 }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="px-6 py-6 font-bold text-gray-900 whitespace-nowrap dark:text-white"
                                                colspan="3" style="text-align: center">
                                                Data Alternatif dan kriteria diperlukan
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
        <x-card title="{{ $setAlternative != null ? 'Edit Alternatif' : 'Tambah Alternatif' }}">
            <x-input wire:model="alternativeName" right-icon="scale" label="Nama Alternatif" class="my-2"
                placeholder="Contoh: Samsung" />
            @if ($criterias->isNotEmpty())
                @foreach ($criterias as $item)
                    <x-inputs.number wire:model="criteriaVals.{{ $item->id }}" label="{{ $item->name }}"
                        aria-placeholder="1-5" class="my-2" />
                @endforeach
            @else
                <p class="px-6 py-6 font-bold text-gray-900 whitespace-nowrap dark:text-white" align="center">
                    Belum ada Alternatif yang diinput
                </p>
            @endif

            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Cancel" x-on:click="close" />
                    @if ($criterias->isEmpty())
                        <x-button primary label="Simpan" disabled
                            wire:click.prevent="{{ $setAlternative != null ? 'putAlternative' : 'saveAlternative' }}" />
                    @else
                        <x-button primary label="Simpan"
                            wire:click.prevent="{{ $setAlternative != null ? 'putAlternative' : 'saveAlternative' }}" />
                    @endif
                </div>
            </x-slot>
        </x-card>
    </x-modal>
</div>
