<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poster extends Model
{
    protected $fillable = ['judul', 'gambar', 'pembuat', 'deskripsi', 'nim', 'is_bidikmisi'];

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function getVoteCountAttribute(): int
    {
        return $this->votes()->count();
    }

    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->gambar);
    }
}