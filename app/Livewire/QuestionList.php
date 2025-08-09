<?php

namespace App\Livewire;

use App\Models\Qbank\Question;
use Livewire\Component;
use Livewire\WithPagination;

class QuestionList extends Component
{
    use WithPagination;

    public $search = '';
    public $subject = '';
    public $chapter = '';

    protected $paginationTheme = 'tailwind'; // ডার্ক/লাইট টেইলউইন্ডে সাপোর্টের জন্য

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSubject()
    {
        $this->resetPage();
    }

    public function updatingChapter()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();
        $this->dispatchBrowserEvent('toast', ['message' => 'Question deleted successfully!', 'type' => 'danger']);
    }

    public function render()
    {
        $questions = Question::with(['subject', 'chapter', 'tags'])
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->where('question', 'like', '%' . $this->search . '%')
                        ->orWhereHas('subject', fn($sub) =>
                        $sub->where('name', 'like', '%' . $this->search . '%')
                        )
                        ->orWhereHas('chapter', fn($chap) =>
                        $chap->where('name', 'like', '%' . $this->search . '%')
                        );
                });
            })
            ->when($this->subject, fn($q) =>
            $q->where('subject_id', $this->subject)
            )
            ->when($this->chapter, fn($q) =>
            $q->where('chapter_id', $this->chapter)
            )
            ->latest()
            ->paginate(5);

        return view('livewire.question-list', [
            'questions' => $questions
        ]);
    }
}
