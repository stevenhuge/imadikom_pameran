<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poster extends Model
{
    protected $fillable = ['judul', 'gambar', 'file_karya', 'user_id', 'pembuat', 'deskripsi', 'nim', 'is_bidikmisi', 'competition_id', 'is_visible', 'file_ktm', 'file_kipk'];

    protected $casts = [
        'is_visible' => 'boolean',
        'is_bidikmisi' => 'boolean',
    ];

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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