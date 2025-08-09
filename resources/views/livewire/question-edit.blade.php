<div class="p-6 bg-white dark:bg-gray-900 dark:text-gray-100 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 transition-all">
    <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-gray-100">Edit Question</h2>

    <form wire:submit.prevent="update" class="space-y-6 mt-4">
        <!-- Question -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Question</label>
            <input type="text" wire:model.defer="question" class="w-full mt-1 p-3 border rounded-lg dark:bg-gray-800 dark:border-gray-700" />
            @error('question') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        <!-- Description -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
            <textarea wire:model.defer="description" class="w-full mt-1 p-3 border rounded-lg dark:bg-gray-800 dark:border-gray-700"></textarea>
            @error('description') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        <!-- Options with radio for correct -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Options</label>
            <div class="space-y-3">
                @foreach($options as $i => $opt)
                    <div class="flex items-center gap-3">
                        <input type="radio" wire:model="correct_answer_index" value="{{ $i }}" class="h-4 w-4 text-indigo-600" />
                        <input type="text" wire:model.defer="options.{{ $i }}" placeholder="Option {{ $i + 1 }}" class="flex-1 p-2 border rounded dark:bg-gray-800 dark:border-gray-700" />
                        <button type="button" wire:click="removeOption({{ $i }})" class="text-sm text-red-500 hover:text-red-700" @if(count($options) <= 2) disabled @endif>Delete</button>
                    </div>
                    @error("options.$i") <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                @endforeach
            </div>

            <div class="mt-2">
                <button type="button" wire:click="addOption" class="px-3 py-1 bg-indigo-600 text-white rounded">Add Option</button>
            </div>
            @error('correct_answer_index') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        <!-- Subject & Chapter -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subject</label>
                <select wire:model.defer="subject_id" class="w-full mt-1 p-3 border rounded dark:bg-gray-800 dark:border-gray-700">
                    <option value="">Select Subject</option>
                    @foreach($subjects as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @endforeach
                </select>
                @error('subject_id') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Chapter</label>
                <select wire:model.defer="chapter_id" class="w-full mt-1 p-3 border rounded dark:bg-gray-800 dark:border-gray-700">
                    <option value="">Select Chapter</option>
                    @foreach($chapters as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
                @error('chapter_id') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Tags multiselect -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tags</label>
            <select wire:model="selected_tags" multiple class="w-full mt-1 p-3 border rounded dark:bg-gray-800 dark:border-gray-700">
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
            @error('selected_tags') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
        </div>

        <!-- Submit -->
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg">Update Question</button>
        </div>
    </form>

    <!-- Toast (simple) -->
    <div x-data="{ show: false, message: '', type: 'success' }"
         x-on:toast.window="message = $event.detail.message; type = $event.detail.type || 'success'; show = true; setTimeout(()=> show=false, 3000)"
         class="fixed top-5 right-5 z-50">
        <template x-if="show">
            <div x-bind:class="type === 'success' ? 'bg-green-500' : 'bg-red-500'"
                 class="text-white px-4 py-2 rounded shadow">
                <span x-text="message"></span>
            </div>
        </template>
    </div>
</div>
