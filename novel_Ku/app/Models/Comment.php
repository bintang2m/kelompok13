<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id', 'novel_id', 'chapter_id', 'parent_id', 'content'];

    public function user() { return $this->belongsTo(User::class); }
    public function novel() { return $this->belongsTo(Novel::class); }
    public function chapter() { return $this->belongsTo(Chapter::class); }
    public function parent() { return $this->belongsTo(Comment::class, 'parent_id'); }
    public function replies() { return $this->hasMany(Comment::class, 'parent_id'); }
    public function likes() { return $this->hasMany(CommentLike::class); }
    public function reports() { return $this->hasMany(Report::class); }
}
