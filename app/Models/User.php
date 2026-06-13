<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime', 'password' => 'hashed'];

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function votedPoster()
    {
        return $this->hasOneThrough(Poster::class, Vote::class, 'user_id', 'id', 'id', 'poster_id');
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'superadmin']);
    }

    public function isSuperadmin(): bool
    {
        return $this->role === 'superadmin';
    }

    public function hasVoted(): bool
    {
        return $this->votes()->exists();
    }

    public function hasVotedFor(int $posterId): bool
    {
        return $this->votes()->where('poster_id', $posterId)->exists();
    }
}