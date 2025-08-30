<div class="p-4 sm:p-6 bg-white dark:bg-gray-900 dark:text-gray-100 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800">
    {{-- Header --}}
    <div class="flex flex-wrap items-center justify-between mb-6">
        <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">📋 All Questions</h2>
        <a href="{{ route('questions.create') }}"
           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold rounded-lg shadow hover:shadow-md hover:scale-105 transform transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Create Question
        </a>
    </div>

    {{-- Filters --}}
    <div class="flex flex-wrap gap-3 mb-6">
        <input type="text" placeholder="🔍 Search..." wire:model.live="search" class="px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg w-full sm:w-1/3 focus:outline-none focus:ring-2 focus:ring-indigo-400 dark:bg-gray-800 dark:text-white transition"/>
        <select wire:model.live="subject" class="px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 dark:bg-gray-800 dark:text-white transition">
            <option value="">All Subjects</option>
            @foreach($subjects as $subj)
                <option value="{{ $subj->id }}">{{ $subj->name }}</option>
            @endforeach
        </select>
        <select wire:model.live="chapter" class="px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 dark:bg-gray-800 dark:text-white transition">
            <option value="">All Chapters</option>
            @foreach($chapters as $chap)
                <option value="{{ $chap->id }}">{{ $chap->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto rounded-lg shadow border border-gray-200 dark:border-gray-800">
        <table class="min-w-full text-sm">
            <thead class="bg-gradient-to-r from-gray-200 to-gray-300 dark:from-gray-800 dark:to-gray-700 text-gray-700 dark:text-gray-200 uppercase text-xs">
            <tr>
                <th class="px-4 py-3 text-left">Question</th>
                <th class="px-4 py-3 text-left">Options</th>
                <th class="px-4 py-3 text-left">Subject</th>
                <th class="px-4 py-3 text-left">Chapter</th>
                <th class="px-4 py-3 text-center">Actions</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($questions as $q)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    <td class="px-4 py-3 font-medium">{!! $q->question !!}</td>
                    <td class="px-4 py-3">
                        @foreach($q->options as $index => $opt)
                            <span class="block @if($index == $q->correct_answer_index) font-bold text-blue-500 @endif">{{ $opt }}</span>
                        @endforeach
                    </td>
                    <td class="px-4 py-3">{{ $q->subject?->name }}</td>
                    <td class="px-4 py-3">{{ $q->chapter?->name }}</td>
                    <td class="px-4 py-3 text-center flex justify-center items-center gap-2">
                        <a href="{{ route('questions.edit', $q) }}" class="px-3 py-1 text-sm font-medium rounded bg-blue-500 text-white hover:bg-blue-600 transition">Edit</a>
                        <button wire:click="delete({{ $q->id }})" class="px-3 py-1 text-sm font-medium rounded bg-red-500 text-white hover:bg-red-600 transition">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-6 text-gray-500 dark:text-gray-400">No questions found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $questions->links() }}
    </div>
</div>
