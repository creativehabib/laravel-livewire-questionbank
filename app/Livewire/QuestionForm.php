<?php

namespace App\Livewire;

use App\Models\Qbank\Chapter;
use App\Models\Qbank\Question;
use App\Models\Qbank\Subject;
use App\Models\Qbank\Tag;
use Livewire\Component;

class QuestionForm extends Component
{
    public Question $questionModel;

    public $question;
    public $description;
    public $options = [''];
    public $correct_answer_index;
    public $subject_id;
    public $chapter_id;
    public $chapters = [];
    public $tags;
    public $selected_tags = [];

    public function mount(Question $question)
    {
        $this->questionModel = $question;
        $this->tags = Tag::pluck('name', 'id');

        if ($this->questionModel->exists) {
            $this->question = $question->question;
            $this->description = $question->description;
            $this->options = $question->options;
            $this->correct_answer_index = $question->correct_answer_index;
            $this->subject_id = $question->subject_id;
            $this->updatedSubjectId($this->subject_id); // Load chapters for the selected subject
            $this->chapter_id = $question->chapter_id;
            $this->selected_tags = $question->tags->pluck('id')->toArray();
        }
    }

    public function updatedSubjectId($subjectId)
    {
        if ($subjectId) {
            $this->chapters = Chapter::where('subject_id', $subjectId)->get();
            $this->chapter_id = null; // Reset chapter when subject changes
        } else {
            $this->chapters = [];
        }
    }

    public function addOption()
    {
        $this->options[] = '';
    }

    public function removeOption($index)
    {
        unset($this->options[$index]);
        $this->options = array_values($this->options); // Re-index array
    }

    public function save()
    {
        $maxIndex = count($this->options) - 1;

        $validated = $this->validate([
            'question' => 'required|string|max:1000',
            'description' => 'nullable|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string|max:1000',
            'correct_answer_index' => "required|integer|min:0|max:{$maxIndex}",
            'subject_id' => 'required|exists:subjects,id',
            'chapter_id' => 'required|exists:chapters,id',
            'selected_tags' => 'array',
        ]);

        // Create or update question
        $this->questionModel->fill([
            'question' => $validated['question'],
            'description' => $validated['description'],
            'options' => $validated['options'],
            'correct_answer_index' => $validated['correct_answer_index'],
            'subject_id' => $validated['subject_id'],
            'chapter_id' => $validated['chapter_id'],
        ])->save();

        // Handle tags
        $tagIds = [];
        foreach ($this->selected_tags as $tag) {
            if (is_numeric($tag)) {
                $tagIds[] = $tag;
            } else {
                $newTag = Tag::create(['name' => $tag]);
                $tagIds[] = $newTag->id;
            }
        }
        $this->questionModel->tags()->sync($tagIds);

        session()->flash('alert', ['type' => 'success', 'title' => 'Saved!', 'text' => 'Question saved successfully.']);
        return redirect()->route('questions.index');
    }

    public function render()
    {
        $subjects = Subject::all();
        return view('livewire.question-form', [
            'subjects' => $subjects,
        ]);
    }
}
