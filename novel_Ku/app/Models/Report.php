<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['user_id', 'novel_id', 'comment_id', 'reason', 'status'];

    public function user() { return $this->belongsTo(User::class); }
    public function novel() { return $this->belongsTo(Novel::class); }
    public function comment() { return $this->belongsTo(Comment::class); }
}
