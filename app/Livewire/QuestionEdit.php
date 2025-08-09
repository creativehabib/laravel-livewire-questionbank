<?php

namespace App\Livewire;

use App\Models\Qbank\Question;
use App\Models\Qbank\Subject;
use App\Models\Qbank\Chapter;
use App\Models\Qbank\Tag;
use Livewire\Component;

class QuestionEdit extends Component
{
    public Question $questionModel;
    public $question;
    public $description;
    public $options = [];
    public $correct_answer_index;
    public $subject_id;
    public $chapter_id;
    public $selected_tags = [];

    public function mount(Question $question)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');
        }

        $this->questionModel = $question;
        $this->question = $question->question;
        $this->description = $question->description;
        $this->options = json_decode($question->options, true) ?? [];
        $this->correct_answer_index = $question->correct_answer_index;
        $this->subject_id = $question->subject_id;
        $this->chapter_id = $question->chapter_id;
        $this->selected_tags = $question->tags()->pluck('id')->toArray();
    }

    public function update()
    {
        $this->validate([
            'question' => 'required|string|max:255',
            'description' => 'nullable|string',
            'options' => 'required|array|min:2',
            'correct_answer_index' => 'required|integer|min:0|max:3',
            'subject_id' => 'required|exists:subjects,id',
            'chapter_id' => 'required|exists:chapters,id',
            'selected_tags' => 'array',
            'selected_tags.*' => 'exists:tags,id',
        ]);

        $this->questionModel->update([
            'question' => $this->question,
            'description' => $this->description,
            'options' => json_encode($this->options),
            'correct_answer_index' => $this->correct_answer_index,
            'subject_id' => $this->subject_id,
            'chapter_id' => $this->chapter_id,
        ]);

        $this->questionModel->tags()->sync($this->selected_tags);

        $this->dispatchBrowserEvent('toast', ['message' => 'Question updated successfully!', 'type' => 'success']);
    }

    public function render()
    {
        $subjects = Subject::all();
        $chapters = Chapter::all();
        $tags = Tag::all();

        return view('livewire.question-edit', [
            'subjects' => $subjects,
            'chapters' => $chapters,
            'tags' => $tags,
        ]);
    }
}

