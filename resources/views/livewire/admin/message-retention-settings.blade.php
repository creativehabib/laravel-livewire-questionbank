<div class="p-4">
    <h2 class="text-2xl font-bold mb-4">Message Retention Settings</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-4 max-w-sm">
        <div>
            <label for="retentionHours" class="block font-medium">Delete messages after (hours)</label>
            <input id="retentionHours" type="number" min="1" wire:model="retentionHours" class="mt-1 w-full border rounded p-2">
            @error('retentionHours') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Save
        </button>
    </form>
</div>
