<?php

namespace App\Models\Qbank;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'question',
        'description',
        'options',
        'correct_answer_index',
        'subject_id',
        'chapter_id',
    ];

    /**
     * Get the subject associated with the question.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');  // Define the relationship
    }

    /**
     * Get the chapter associated with the question.
     */
    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id');  // Define the relationship
    }

    /**
     * Tags attached to the question.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
