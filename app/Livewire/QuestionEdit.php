<?php

namespace App\Livewire;

use App\Models\Qbank\Question;
use App\Models\Qbank\Subject;
use App\Models\Qbank\Chapter;
use Livewire\Component;

class QuestionEdit extends Component
{
    public Question $questionModel;
    public $question;
    public $options = [];
    public $correct_answer_index;
    public $subject_id;
    public $chapter_id;

    public function mount(Question $question)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }

        $this->questionModel = $question;
        $this->question = $question->question;
        $this->options = json_decode($question->options, true) ?? [];
        $this->correct_answer_index = $question->correct_answer_index;
        $this->subject_id = $question->subject_id;
        $this->chapter_id = $question->chapter_id;
    }

    public function update()
    {
        $this->validate([
            'question' => 'required|string|max:255',
            'options' => 'required|array|min:2',
            'correct_answer_index' => 'required|integer|min:0|max:3',
            'subject_id' => 'required|exists:subjects,id',
            'chapter_id' => 'required|exists:chapters,id',
        ]);

        $this->questionModel->update([
            'question' => $this->question,
            'options' => json_encode($this->options),
            'correct_answer_index' => $this->correct_answer_index,
            'subject_id' => $this->subject_id,
            'chapter_id' => $this->chapter_id,
        ]);

        session()->flash('message', 'Question updated successfully!');
    }

    public function render()
    {
        $subjects = Subject::all();
        $chapters = Chapter::all();

        return view('livewire.question-edit', [
            'subjects' => $subjects,
            'chapters' => $chapters,
        ]);
    }
}

