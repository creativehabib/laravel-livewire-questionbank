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
            <label for="options" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Options</label>
            <div class="space-y-3">
                @for($i = 0; $i < 4; $i++)
                    <input type="text" wire:model="options.{{ $i }}" placeholder="Option {{ $i + 1 }}" class="w-full p-3 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white transition-all">
                    @error("options.$i")
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                @endfor
            </div>
        </div>

        <!-- Correct Answer Selection -->
        <div>
            <label for="correct_answer_index" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Correct Option</label>
            <select wire:model="correct_answer_index" id="correct_answer_index" class="w-full mt-1 p-3 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-white transition-all" required>
                <option value="">Select Correct Option</option>
                <option value="0">Option 1</option>
                <option value="1">Option 2</option>
                <option value="2">Option 3</option>
                <option value="3">Option 4</option>
            </select>
            @error('correct_answer_index')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
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
            <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition-all focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-indigo-800 dark:hover:bg-indigo-700 dark:focus:ring-indigo-500">
                Create Question
            </button>
        </div>

    </form>
</div>
