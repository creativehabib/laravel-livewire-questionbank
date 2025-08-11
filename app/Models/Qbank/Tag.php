<?php

namespace App\Models\Qbank;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }
}
