<?php

namespace App\Livewire;

use App\Models\Qbank\Question;
use App\Models\Qbank\Subject;
use App\Models\Qbank\Chapter;
use App\Models\Qbank\Tag;
use Livewire\Component;

class QuestionEdit extends Component
{
    public $questionModel;
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

        // Only decode JSON if options is not already an array
        $this->options = is_array($question->options) ? $question->options : json_decode($question->options, true);

        $this->correct_answer_index = $question->correct_answer_index;
        $this->subject_id = $question->subject_id;
        $this->chapter_id = $question->chapter_id;
        $this->selected_tags = $question->tags()->pluck('tags.id')->toArray();
    }

    public function addOption()
    {
        $this->options[] = '';
    }

    public function removeOption($index)
    {
        if (count($this->options) <= 2) {
            $this->dispatchBrowserEvent('toast', ['message' => 'At least 2 options required', 'type' => 'error']);
            return;
        }

        array_splice($this->options, $index, 1);

        // Adjust correct_answer_index
        if ($this->correct_answer_index === null) {
            // Nothing to adjust
        } elseif ($this->correct_answer_index == $index) {
            $this->correct_answer_index = null;
        } elseif ($this->correct_answer_index > $index) {
            $this->correct_answer_index = $this->correct_answer_index - 1;
        }
    }

    public function update()
    {
        $maxIndex = max(0, count($this->options) - 1);

        $this->validate([
            'question' => 'required|string|max:255',
            'description' => 'nullable|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string|max:1000',
            'correct_answer_index' => "required|integer|min:0|max:{$maxIndex}",
            'subject_id' => 'required|exists:subjects,id',
            'chapter_id' => 'required|exists:chapters,id',
            'selected_tags' => 'array',
            'selected_tags.*' => 'exists:tags,id',
        ]);

        // Save question
        $this->questionModel->update([
            'question' => $this->question,
            'description' => $this->description,
            'options' => $this->options, // Will be cast to JSON by model
            'correct_answer_index' => $this->correct_answer_index,
            'subject_id' => $this->subject_id,
            'chapter_id' => $this->chapter_id,
        ]);

        // Sync selected tags
        $this->questionModel->tags()->sync($this->selected_tags);

        // Dispatch success toast message
//        $this->dispatchBrowserEvent('toast', ['message' => 'Question updated successfully!', 'type' => 'success']);
        return redirect()->route('questions');
    }

    public function render()
    {
        $subjects = Subject::all();
        $chapters = Chapter::all();
        $tags = Tag::all();

        return view('livewire.question-edit', compact('subjects', 'chapters', 'tags'));
    }
}

