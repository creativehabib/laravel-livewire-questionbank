<div class="container mx-auto p-6">
    @if(session()->has('score'))
        {{-- পরীক্ষার ফলাফল দেখানোর সেকশন --}}
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg" role="alert">
            <h2 class="font-bold text-2xl mb-2">পরীক্ষা সম্পন্ন হয়েছে!</h2>
            <p class="text-xl">{{ session('score') }}</p>
            <a href="{{ route('dashboard') }}" class="mt-4 inline-block bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">ড্যাশবোর্ডে ফিরে যান</a>
        </div>
    @elseif($submitted)
        {{-- সাবমিট করার পর লোডিং অবস্থা --}}
        <div class="text-center">
            <h2 class="text-2xl font-semibold">ফলাফল প্রসেস করা হচ্ছে...</h2>
            <p>অনুগ্রহ করে অপেক্ষা করুন।</p>
        </div>
    @else
        {{-- পরীক্ষার মূল ইন্টারফেস --}}
        <div x-data="{
            time: @entangle('timeRemaining'),
            timer: null,
            init() {
                this.timer = setInterval(() => {
                    if (this.time > 0) {
                        this.time--;
                    } else {
                        clearInterval(this.timer);
                        $wire.submit();
                    }
                }, 1000);
            },
            formatTime() {
                const minutes = Math.floor(this.time / 60);
                const seconds = this.time % 60;
                return `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            }
        }" x-init="init()">

            {{-- ধাপ ১: টাইমার এবং পরীক্ষার শিরোনাম --}}
            <div class="flex justify-between items-center mb-6 p-4 bg-gray-100 rounded-lg shadow sticky top-0 z-10">
                <h1 class="text-2xl font-bold text-gray-800">MCQ পরীক্ষা</h1>
                <div class="text-xl font-semibold text-red-600" x-text="`সময় বাকি: ${formatTime()}`"></div>
                <span class="text-lg font-medium text-gray-700">মোট প্রশ্ন: {{ count($questions) }}</span>
            </div>

            {{-- প্রশ্নাবলী --}}
            <div class="space-y-8">
                @foreach ($questions as $index => $question)
                    <div wire:key="{{ $question->id }}" class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                        {{-- প্রশ্ন --}}
                        <div class="flex items-start mb-4">
                            <span class="font-bold text-lg mr-3">{{ $index + 1 }}.</span>
                            <p class="text-lg text-gray-900">{{ $question->question }}</p>
                        </div>

                        {{-- অপশন --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($question->options as $optionIndex => $option)
                                @php
                                    $isAnswered = $userAnswers[$question->id] !== null;
                                    $isSelected = $userAnswers[$question->id] === $optionIndex;
                                    $isCorrect = $question->correct_answer_index === $optionIndex;
                                @endphp
                                <label
                                    class="p-4 rounded-lg border transition-all duration-300 flex items-center
                                        @if($isAnswered)
                                            @if($isCorrect) bg-green-500 border-green-600 text-white
                                            @elseif($isSelected) bg-red-500 border-red-600 text-white
                                            @else opacity-50 cursor-not-allowed
                                            @endif
                                        @else bg-gray-100 border-gray-300 hover:bg-gray-200 cursor-pointer
                                        @endif
                                    "
                                >
                                    <input
                                        type="radio"
                                        name="question_{{ $question->id }}"
                                        wire:click="checkAnswer({{ $question->id }}, {{ $optionIndex }})"
                                        value="{{ $optionIndex }}"
                                        class="hidden"
                                        @if($isAnswered) disabled @endif
                                    >
                                    <span>{{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ধাপ ২: পরীক্ষা জমা দিন বাটন --}}
            <div class="mt-8 text-center">
                <button wire:click="submit" wire:loading.attr="disabled" class="w-full md:w-auto bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition-transform transform hover:scale-105">
                    <span wire:loading.remove>পরীক্ষা জমা দিন</span>
                    <span wire:loading>সাবমিট হচ্ছে...</span>
                </button>
            </div>
        </div>
    @endif
</div>
