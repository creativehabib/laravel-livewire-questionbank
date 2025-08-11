<div class="p-4">
    <h2 class="text-2xl font-bold mb-4">Subject Management</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="mb-4">
        <input type="text" wire:model="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Subject Name">
        @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
    </div>

    @if ($updateMode)
        <button wire:click="update()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update</button>
    @else
        <button wire:click="store()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Create</button>
    @endif

    <table class="table-auto w-full mt-6">
        <thead>
        <tr>
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($subjects as $subject)
            <tr>
                <td class="border px-4 py-2">{{ $subject->name }}</td>
                <td class="border px-4 py-2">
                    <button wire:click="edit({{ $subject->id }})" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded">Edit</button>
                    <button wire:click="delete({{ $subject->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">Delete</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $subjects->links() }}
    </div>
</div>
