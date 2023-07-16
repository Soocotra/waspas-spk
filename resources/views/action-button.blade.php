<input type="hidden" value="{{ $row->id }}" wire:model='projectId'>
<button class="bg-red-500 hover:bg-blue-700 text-white font-bold p-1 rounded m-1"
    wire:click="deleteConfirm({{ $row->id }})">
    <x-icon name="trash" class="w-5 h-5" />
</button>
