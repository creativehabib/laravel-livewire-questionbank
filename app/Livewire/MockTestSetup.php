<?php

namespace App\Livewire;

use App\Models\Qbank\Question;
use App\Models\Qbank\Subject;
use Livewire\Component;

class MockTestSetup extends Component
{
    public $subjects_with_chapters;

    // ব্যবহারকারীর নির্বাচনের জন্য ভেরিয়েবল
    public $selectedChapters = [];
    public $questionCount = 10;
    public $timeInMinutes = 10;
    public $hasNegativeMarking = false;

    public function mount()
    {
        $this->subjects_with_chapters = Subject::with('chapters')->get();
    }

    /**
     * পরীক্ষা শুরু করার ফাংশন
     */
    public function startExam()
    {
        // ব্যবহারকারীর ইনপুট ভ্যালিডেট করুন
        $this->validate([
            'selectedChapters' => 'required|array|min:1',
            'questionCount' => 'required|integer|min:1|max:100',
            'timeInMinutes' => 'required|integer|min:1',
        ], [
            'selectedChapters.required' => 'অনুগ্রহ করে অন্তত একটি অধ্যায় নির্বাচন করুন।',
        ]);

        // নির্বাচিত অধ্যায়গুলো থেকে প্রশ্ন খুঁজে বের করুন
        $questions = Question::whereIn('chapter_id', $this->selectedChapters)
            ->inRandomOrder()
            ->take($this->questionCount)
            ->pluck('id'); // শুধু প্রশ্নের আইডিগুলো নিন

        // যদি পর্যাপ্ত প্রশ্ন না পাওয়া যায়
        if ($questions->count() < $this->questionCount) {
            session()->flash('error', "আপনার নির্বাচিত অধ্যায়ে মাত্র {$questions->count()} টি প্রশ্ন পাওয়া গেছে। অনুগ্রহ করে প্রশ্নের সংখ্যা কমান অথবা আরও অধ্যায় যোগ করুন।");
            return;
        }

        // পরীক্ষার সেটিংস সেশনে সেভ করুন
        session([
            'exam_questions' => $questions->toArray(),
            'exam_time' => $this->timeInMinutes,
            'exam_negative_marking' => $this->hasNegativeMarking,
        ]);

        // পরীক্ষার পেজে রিডাইরেক্ট করুন
        return redirect()->route('exam.start');
    }

    public function render()
    {
        return view('livewire.mock-test-setup');
    }
}
