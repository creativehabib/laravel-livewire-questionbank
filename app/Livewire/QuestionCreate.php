<?php

namespace App\Livewire;

use App\Models\Qbank\Question;
use App\Models\Qbank\Subject;  // Assuming you have a Subject model
use App\Models\Qbank\Chapter;  // Assuming you have a Chapter model
use App\Models\Qbank\Tag;
use Livewire\Component;

class QuestionCreate extends Component
{
    public $question, $description, $options = [''], $correct_answer_index;
    public $subject_id, $chapter_id;  // New properties for subject and chapter
    public $optionsChecked = [];
    public $selected_tags = [];

    // Mount method to ensure only admin users have access
    public function mount()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');  // Redirect to homepage if user is not admin
        }
    }

    // Add a new option field dynamically
    public function addOption()
    {
        $this->options[] = ''; // Add an empty option
        $this->optionsChecked[] = false; // Add a checkbox state
    }

    // Remove an option field dynamically
    public function removeOption($index)
    {
        if (count($this->options) > 2) { // কমপক্ষে 2 অপশন থাকতে হবে
            array_splice($this->options, $index, 1);

            // যদি রিমুভ করা অপশন সঠিক উত্তর হয়, reset করবো
            if ($this->correct_answer_index == $index) {
                $this->correct_answer_index = null;
            }
        }
    }

    // Validation and data submission
    public function submit()
    {
        // Validate all fields, including subject_id and chapter_id
        $this->validate([
            'question' => 'required|string|max:255',
            'description' => 'nullable|string',
            'options' => 'required|array|min:2',  // At least 2 options
            'correct_answer_index' => 'required|integer|min:0|max:' . (count($this->options) - 1),  // Valid index for options
            'subject_id' => 'required|exists:subjects,id',  // Validate subject_id exists in the subject table
            'chapter_id' => 'required|exists:chapters,id',  // Validate chapter_id exists in the chapter table
            'selected_tags' => 'array',
            'selected_tags.*' => 'exists:tags,id',
        ]);

        // Create a new question record
        $question = Question::create([
            'question' => $this->question,
            'description' => $this->description,
            'options' => json_encode($this->options),  // Store options as JSON
            'correct_answer_index' => $this->correct_answer_index,
            'subject_id' => $this->subject_id,  // Pass subject_id
            'chapter_id' => $this->chapter_id,  // Pass chapter_id
        ]);

        $question->tags()->sync($this->selected_tags);  // Sync the selected tags

        session()->flash('success', 'Question created successfully!');
        $this->reset(['question', 'description', 'options', 'correct_answer_index', 'subject_id', 'chapter_id', 'selected_tags']);
        $this->options = ['', '']; // ডিফল্ট 2টা অপশন রাখবো
    }

    // Render the component
    public function render()
    {
        // Get subjects and chapters for dropdown options
        $subjects = Subject::all();  // Assuming you have a Subject model
        $chapters = Chapter::all();  // Assuming you have a Chapter model
        $tags = Tag::all();

        return view('livewire.question-create', [
            'subjects' => $subjects,
            'chapters' => $chapters,
            'tags' => $tags,
        ]);
    }
}
