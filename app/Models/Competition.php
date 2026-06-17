<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'year',
        'theme',
        'fee_type',
        'is_active',
        'voting_status',
        'voting_deadline',
        'registration_status',
        'registration_deadline',
        'eligibility_type',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'voting_deadline' => 'datetime',
        'registration_deadline' => 'datetime',
        'eligibility_type' => 'integer',
    ];

    public function posters()
    {
        return $this->hasMany(Poster::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
