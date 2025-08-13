<div class="bg-gray-800 text-white min-h-screen p-6 md:p-8">
    <div class="max-w-5xl mx-auto">
        <div class="text-center md:text-left mb-10">
            <h1 class="text-3xl font-bold">মক পরীক্ষা</h1>
            <p class="text-gray-400 mt-2">আপনার পছন্দের বিষয় ও অধ্যায় নির্বাচন করে পরীক্ষা শুরু করুন।</p>
        </div>

        @if (session()->has('error'))
            <div class="bg-red-500 text-white p-4 rounded-lg mb-6 shadow-lg">
                {{ session('error') }}
            </div>
        @endif
        @error('selectedChapters') <span class="text-red-400 mb-4 block">{{ $message }}</span> @enderror

        <div class="bg-gray-900 p-6 md:p-8 rounded-xl shadow-lg">
            <h2 class="text-xl font-semibold mb-6 border-b border-gray-700 pb-3">কোন বিষয়ে পরীক্ষা দিতে চাও?</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                @php
                    $chunks = $subjects_with_chapters->chunk(ceil($subjects_with_chapters->count() / 2));
                @endphp
                @foreach($chunks as $chunk)
                    <div class="space-y-6">
                        @foreach($chunk as $subject)
                            <div class="subject-group">
                                <h3 class="text-lg font-semibold mb-3">{{ $subject->name }}</h3>
                                <div class="pl-4 space-y-2 border-l-2 border-gray-700">
                                    @foreach($subject->chapters as $chapter)
                                        <label class="flex items-center space-x-3 text-gray-400 hover:text-white transition-colors duration-200 cursor-pointer">
                                            <input type="checkbox" wire:model.live="selectedChapters" value="{{ $chapter->id }}" class="form-checkbox h-4 w-4 bg-gray-700 border-gray-600 rounded text-green-500 focus:ring-green-500">
                                            <span>{{ $chapter->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-10 flex flex-col md:flex-row justify-between items-center bg-gray-900 p-6 rounded-xl shadow-lg">
            <div class="flex flex-wrap items-center gap-6 mb-6 md:mb-0">
                <div>
                    <label for="question_count" class="block mb-2 text-sm font-medium text-gray-400">প্রশ্ন সংখ্যা</label>
                    <input type="number" wire:model="questionCount" id="question_count" class="bg-gray-800 border border-gray-600 rounded-md px-4 py-2 w-32 focus:ring-green-500 focus:border-green-500">
                </div>
                <div>
                    <label for="timer" class="block mb-2 text-sm font-medium text-gray-400">সময় (মিনিট)</label>
                    <input type="number" wire:model="timeInMinutes" id="timer" class="bg-gray-800 border border-gray-600 rounded-md px-4 py-2 w-32 focus:ring-green-500 focus:border-green-500">
                </div>
                <div class="flex items-center pt-6">
                    <label class="flex items-center space-x-3 text-gray-400 cursor-pointer">
                        <input type="checkbox" wire:model="hasNegativeMarking" class="form-checkbox h-5 w-5 bg-gray-700 border-gray-600 rounded text-green-500 focus:ring-green-500">
                        <span>নেগেটিভ মার্কিং</span>
                    </label>
                </div>
            </div>
            <button wire:click="startExam" wire:loading.attr="disabled" class="w-full md:w-auto bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-12 rounded-lg transition-transform transform hover:scale-105">
                <span wire:loading.remove>এগিয়ে যাও</span>
                <span wire:loading>অপেক্ষা করুন...</span>
            </button>
        </div>
    </div>
</div>
