<?php

namespace App\Livewire;

use App\Models\Qbank\Question;
use App\Models\Qbank\Subject;  // Assuming you have a Subject model
use App\Models\Qbank\Chapter;  // Assuming you have a Chapter model
use Livewire\Component;

class QuestionCreate extends Component
{
    public $question, $options = [], $correct_answer_index;
    public $subject_id, $chapter_id;  // New properties for subject and chapter

    // Mount method to ensure only admin users have access
    public function mount()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect('/');  // Redirect to homepage if user is not admin
        }
    }

    // Validation and data submission
    public function submit()
    {
        // Validate all fields, including subject_id and chapter_id
        $this->validate([
            'question' => 'required|string|max:255',
            'options' => 'required|array|min:2',  // At least 2 options
            'correct_answer_index' => 'required|integer|min:0|max:3',  // Valid index for options
            'subject_id' => 'required|exists:subjects,id',  // Validate subject_id exists in the subjects table
            'chapter_id' => 'required|exists:chapters,id',  // Validate chapter_id exists in the chapters table
        ]);

        // Create a new question record
        Question::create([
            'question' => $this->question,
            'options' => json_encode($this->options),  // Store options as JSON
            'correct_answer_index' => $this->correct_answer_index,
            'subject_id' => $this->subject_id,  // Pass subject_id
            'chapter_id' => $this->chapter_id,  // Pass chapter_id
        ]);

        // Provide feedback to the user
        session()->flash('message', 'Question created successfully!');

        // Reset the form after submission
        $this->reset();
    }

    // Render the component
    public function render()
    {
        // Get subjects and chapters for dropdown options
        $subjects = Subject::all();  // Assuming you have a Subject model
        $chapters = Chapter::all();  // Assuming you have a Chapter model

        return view('livewire.question-create', [
            'subjects' => $subjects,
            'chapters' => $chapters,
        ]);
    }
}

