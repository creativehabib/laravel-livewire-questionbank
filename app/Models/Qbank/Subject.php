<?php

namespace App\Models\Qbank;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name'];

    public function questions()
    {
        return $this->hasMany(Question::class, 'subject_id');
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class, 'subject_id');
    }
}
