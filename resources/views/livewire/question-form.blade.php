<form wire:submit.prevent="save" class="p-6 bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800">
    <div class="space-y-6">
        {{-- Question Text --}}
        <div>
            <label for="question" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Question</label>
            <x-tiptap-editor wire:model="question" id="question" />
            @error('question') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        {{-- Description --}}
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
            <x-tiptap-editor wire:model="description" id="description" />
            @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        {{-- Options --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Options</label>
            <div class="space-y-2 mt-1">
                @foreach($options as $index => $option)
                    <div class="flex items-center gap-2">
                        <input type="radio" name="correct_answer_index" value="{{ $index }}" wire:model.defer="correct_answer_index" class="form-radio h-4 w-4 text-indigo-600">
                        <input type="text" wire:model.defer="options.{{ $index }}" class="flex-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                        <button type="button" wire:click="removeOption({{ $index }})" class="text-red-500 hover:text-red-700">Remove</button>
                    </div>
                    @error('options.'.$index) <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                @endforeach
            </div>
            @error('correct_answer_index') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            <button type="button" wire:click="addOption" class="mt-2 text-sm text-indigo-600 hover:text-indigo-800">Add Option</button>
        </div>

        {{-- Subject and Chapter --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="subject_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subject</label>
                <select id="subject_id" wire:model.live="subject_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white">
                    <option value="">Select Subject</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
                @error('subject_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="chapter_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Chapter</label>
                <select id="chapter_id" wire:model.defer="chapter_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white" @if(!$chapters) disabled @endif>
                    <option value="">Select Chapter</option>
                    @foreach($chapters as $chapter)
                        <option value="{{ $chapter->id }}">{{ $chapter->name }}</option>
                    @endforeach
                </select>
                @error('chapter_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        {{-- Tags --}}
        <div wire:ignore x-data x-init="new TomSelect($refs.select, { create: true, plugins: ['remove_button'], onChange: (value) => { @this.set('selected_tags', value); } });">
            <label for="tags" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tags</label>
            <select x-ref="select" id="tags" multiple placeholder="Select or create tags..." autocomplete="off" class="tom-select">
                @foreach($tags as $id => $name)
                    <option value="{{ $id }}" @if(in_array($id, $selected_tags)) selected @endif>{{ $name }}</option>
                @endforeach
            </select>
        </div>

    </div>

    <div class="mt-8 flex justify-end">
        <button type="submit" class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-green-500 to-teal-600 text-white font-semibold rounded-lg shadow">
            Save Question
        </button>
    </div>
</form>
