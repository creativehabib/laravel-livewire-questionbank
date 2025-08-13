<?php

namespace App\Livewire;

use App\Livewire\Traits\WithSweetAlert;
use App\Models\Qbank\Chapter;
use App\Models\Qbank\Question;
use App\Models\Qbank\Subject;
use Livewire\Component;
use Livewire\WithPagination;

class QuestionList extends Component
{
    use WithPagination, WithSweetAlert;

    public $search = '';
    public $subject = '';
    public $chapter = '';

    protected $listeners = ['destroy'];

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
        $this->confirm('আপনি কি নিশ্চিত?', 'এই প্রশ্নটি পুনরুদ্ধার করা যাবে না!', 'destroy', ['id' => $id]);
    }

    public function destroy($params)
    {
        $questionId = $params['id'];
        if ($questionId) {
            Question::find($questionId)->delete();
            $this->alert('success', 'প্রশ্ন ডিলিট সম্পন্ন হয়েছে!');
        }
    }

    public function render()
    {
        $questions = Question::with(['subject', 'chapter'])
            ->when($this->search, function ($query) {
                $query->where('question', 'like', '%' . $this->search . '%')
                    ->orWhereRelation('subject', 'name', 'like', '%' . $this->search . '%')
                    ->orWhereRelation('chapter', 'name', 'like', '%' . $this->search . '%');
            })
            ->when($this->subject, fn($query) => $query->where('subject_id', $this->subject))
            ->when($this->chapter, fn($query) => $query->where('chapter_id', $this->chapter))
            ->latest()
            ->paginate(10);

        $subjects = Subject::all();
        $chapters = Chapter::all();

        return view('livewire.question-list', [
            'questions' => $questions,
            'subjects' => $subjects,
            'chapters' => $chapters,
        ]);
    }
}
