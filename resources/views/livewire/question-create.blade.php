<div class="p-6 bg-white dark:bg-gray-900 dark:text-gray-100 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 transition-all">

    <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-gray-100">Create New Question</h2>

    <form wire:submit.prevent="submit" class="space-y-6">
        <!-- Question Input -->
        <div>
            <label for="question" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Question</label>
            <input type="text" wire:model="question" id="question" class="w-full mt-1 p-3 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white transition-all">
            @error('question')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Description Input -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
            <textarea wire:model="description" id="description" class="w-full mt-1 p-3 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white transition-all"></textarea>
            @error('description')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Options Input -->
        <div>
            <label for="options" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Options</label>
            <div class="space-y-3">
                @foreach($options as $index => $option)
                    <div class="flex items-center">
                        <!-- Checkbox to mark the correct option -->
                        <input type="checkbox" wire:model="optionsChecked.{{ $index }}" value="{{ $index }}" class="mr-2">
                        <input type="text" wire:model="options.{{ $index }}" placeholder="Option {{ $index + 1 }}" class="border border-transparent focus:border-transparent focus:outline-none focus:ring-0 w-full">
                        <!-- Delete Button for each option, except the default option -->
                        @if($index > 0)
                            <button type="button" wire:click="removeOption({{ $index }})" class="ml-2 text-red-500 hover:text-red-700">Delete</button>
                        @endif
                    </div>
                    @error("options.$index")
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                @endforeach
            </div>
            <button type="button" wire:click="addOption" class="text-sm text-blue-600 hover:underline">Add Option</button>
        </div>

        <!-- Subject Selection -->
        <div>
            <label for="subject_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Subject</label>
            <select wire:model="subject_id" id="subject_id" class="w-full mt-1 p-3 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white transition-all" required>
                <option value="">Select Subject</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
            @error('subject_id')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Chapter Selection -->
        <div>
            <label for="chapter_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Chapter</label>
            <select wire:model="chapter_id" id="chapter_id" class="w-full mt-1 p-3 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white transition-all" required>
                <option value="">Select Chapter</option>
                @foreach($chapters as $chapter)
                    <option value="{{ $chapter->id }}">{{ $chapter->name }}</option>
                @endforeach
            </select>
            @error('chapter_id')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Tag Selection -->
        <div>
            <label for="tags" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tags</label>
            <select wire:model="selected_tags" id="tags" multiple class="w-full mt-1 p-3 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white transition-all">
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
            @error('selected_tags')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" class="cursor-pointer px-6 py-2 bg-blue-600 text-white rounded-lg">Create Question</button>
        </div>

    </form>
</div>
