<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = ['user_id', 'poster_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function poster()
    {
        return $this->belongsTo(Poster::class);
    }
}