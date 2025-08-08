<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', // Ensure role_id is fillable
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Method to get the user's initials
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    // Relationship with Role model
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Helper methods to check user roles
    public function isAdmin(): bool
    {
        return $this->role->name === 'Admin';
    }

    public function isWriter(): bool
    {
        return $this->role->name === 'Writer';
    }

    public function isUser(): bool
    {
        return $this->role->name === 'User';
    }
}
