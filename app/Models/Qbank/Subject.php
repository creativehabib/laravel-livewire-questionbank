<?php

namespace App\Models\Qbank;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name'];

    /**
     * Get all the questions for the subject.
     */
    public function questions()
    {
        return $this->hasMany(Question::class, 'subject_id');  // Define the inverse relationship
    }
}
