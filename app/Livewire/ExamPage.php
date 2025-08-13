<?php

namespace App\Livewire;

use App\Livewire\Traits\WithSweetAlert;
use App\Models\Qbank\Question;
use Livewire\Component;

class ExamPage extends Component
{
    use WithSweetAlert;

    public $questions;
    public $timeRemaining;
    public $submitted = false;
    public $userAnswers = [];
    public $results = [];
    public $hasNegativeMarking;

    public function mount()
    {
        // সেশন থেকে পরীক্ষার সেটিংস নিন
        $questionIds = session('exam_questions');
        $timeInMinutes = session('exam_time');
        $this->hasNegativeMarking = session('exam_negative_marking', false);

        if (!$questionIds || !$timeInMinutes) {
            session()->flash('error', 'অনুগ্রহ করে প্রথমে একটি পরীক্ষা সেটআপ করুন।');
            return redirect()->route('mock.test');
        }

        $this->questions = Question::whereIn('id', $questionIds)->get();
        $this->timeRemaining = $timeInMinutes * 60;

        foreach ($this->questions as $question) {
            $this->userAnswers[$question->id] = null;
            $this->results[$question->id] = null;
        }
    }

    public function checkAnswer($questionId, $selectedIndex)
    {
        if ($this->userAnswers[$questionId] !== null) {
            return;
        }

        $this->userAnswers[$questionId] = $selectedIndex;
        $question = $this->questions->find($questionId);
        $isCorrect = ($question->correct_answer_index == $selectedIndex);
        $this->results[$questionId] = $isCorrect;

        if ($isCorrect) {
            $this->alert('success', 'সঠিক উত্তর!', 'অভিনন্দন! আপনার উত্তরটি সঠিক।', 2000, false);
        } else {
            $correctOption = $question->options[$question->correct_answer_index];
            $this->alert('error', 'ভুল উত্তর!', "সঠিক উত্তরটি হলো: '{$correctOption}'", null, true);
        }
    }

    public function submit()
    {
        $this->submitted = true;

        $correctAnswers = 0;
        $wrongAnswers = 0;
        $totalQuestions = count($this->questions);

        foreach ($this->results as $result) {
            if ($result === true) {
                $correctAnswers++;
            } elseif ($result === false) {
                $wrongAnswers++;
            }
        }

        $marksDeducted = 0;
        if ($this->hasNegativeMarking) {
            $marksDeducted = $wrongAnswers * 0.25;
        }

        $finalScore = $correctAnswers - $marksDeducted;
        $finalScore = max(0, $finalScore);

        $scoreMessage = "আপনি {$totalQuestions} টি প্রশ্নের মধ্যে {$correctAnswers} টি সঠিক এবং {$wrongAnswers} টি ভুল উত্তর দিয়েছেন।";
        if ($this->hasNegativeMarking) {
            $scoreMessage .= " আপনার চূড়ান্ত স্কোর: {$finalScore}";
        } else {
            $scoreMessage .= " আপনার প্রাপ্ত নম্বর: {$correctAnswers}";
        }

        session()->flash('score', $scoreMessage);
        session()->forget(['exam_questions', 'exam_time', 'exam_negative_marking']);
    }

    public function render()
    {
        return view('livewire.exam-page');
    }
}
