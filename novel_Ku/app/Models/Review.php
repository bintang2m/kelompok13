<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['user_id', 'novel_id', 'rating', 'comment'];

    public function user() { return $this->belongsTo(User::class); }
    public function novel() { return $this->belongsTo(Novel::class); }
}
