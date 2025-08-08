<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name'];

    // One-to-many relationship with User
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
