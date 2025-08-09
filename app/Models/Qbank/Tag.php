<?php

namespace App\Models\Qbank;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = [];

    /**
     * Questions associated with the tag.
     */
    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }
}
