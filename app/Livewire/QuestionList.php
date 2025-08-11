<?php

namespace App\Livewire;

use App\Livewire\Traits\WithSweetAlert;
use App\Models\Qbank\Question;
use Livewire\Component;
use Livewire\WithPagination;

class QuestionList extends Component
{
    use WithPagination, WithSweetAlert;

    public $search = '';
    public $subject = '';
    public $chapter = '';

    protected $paginationTheme = 'tailwind'; // ডার্ক/লাইট টেইলউইন্ডে সাপোর্টের জন্য
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
    // Delete the question
    public function destroy($params)
    {
        // এখন সরাসরি আইডি গ্রহণ করুন
        $questionId = $params['id'];
        if ($questionId) {
            Question::find($questionId)->delete();
            $this->alert('success', 'ডিলিট সম্পন্ন হয়েছে!');
        }
    }
    /**
     * আপনার delete() মেথডটি ঠিক আছে, এটি পরিবর্তন করার প্রয়োজন নেই।
     */
    public function delete($id)
    {
        $this->confirm(
            'আপনি কি নিশ্চিত?',
            'এটি পুনরুদ্ধার করা যাবে না!',
            'destroy',
            ['id' => $id]
        );
    }
    public function render()
    {
        $questions = Question::with(['subject', 'chapter'])
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
