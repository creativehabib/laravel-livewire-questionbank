<?php

namespace App\Livewire\Qbank;

use App\Livewire\Traits\WithSweetAlert;
use App\Models\Qbank\Subject;
use Livewire\Component;
use Livewire\WithPagination;

class SubjectManager extends Component
{
    use WithPagination;
    use WithSweetAlert;

    public $name;
    public $subject_id;
    public $updateMode = false;

    protected $rules = [
        'name' => 'required|string|min:3',
    ];

    // জাভাস্ক্রিপ্ট থেকে 'destroy' ইভেন্টটি শোনার জন্য প্রস্তুত
    protected $listeners = ['destroy'];

    public function render()
    {
        $subjects = Subject::latest()->paginate(10);
        return view('livewire.qbank.subject-manager', compact('subjects'));
    }

    public function store()
    {
        $this->validate();

        Subject::create(['name' => $this->name]);

        // Dispatch browser event instead of session flash
        $this->dispatch('flash-message', message: 'Subject Created Successfully!', type: 'success');
        $this->resetInput();
    }

    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        $this->subject_id = $id;
        $this->name = $subject->name;
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate();

        $subject = Subject::find($this->subject_id);
        $subject->update(['name' => $this->name]);

        $this->dispatch('flash-message', message: 'Subject Updated Successfully!', type: 'success');
        $this->resetInput();
        $this->updateMode = false;
    }

    /**
     * এই ফাংশনটি শুধু কনফার্মেশন পপ-আপ দেখাবে।
     * এটি কোনো কিছু ডিলিট করবে না।
     */
    /**
     * এই মেথডটি শুধুমাত্র ব্যবহারকারীর কনফার্মেশনের পরেই কল হবে।
     * শুধু প্যারামিটারের নামটি পরিবর্তন করুন।
     */
    public function destroy($params) // <-- এখানে '$data' এর পরিবর্তে '$params' লিখুন
    {
        // এখন সরাসরি আইডি গ্রহণ করুন
        $subjectId = $params['id'];

        if ($subjectId) {
            Subject::find($subjectId)->delete();
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

    private function resetInput()
    {
        $this->name = '';
        $this->subject_id = null;
    }
}
