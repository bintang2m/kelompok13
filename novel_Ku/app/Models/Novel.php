<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Novel extends Model
{
    protected $fillable = ['user_id', 'title', 'description', 'cover', 'status', 'publish_status', 'views'];

    public function author() { return $this->belongsTo(User::class, 'user_id'); }
    public function chapters() { return $this->hasMany(Chapter::class); }
    public function genres() { return $this->belongsToMany(Genre::class, 'novel_genre'); }
    public function comments() { return $this->hasMany(Comment::class); }
    public function reviews() { return $this->hasMany(Review::class); }
    public function bookmarks() { return $this->hasMany(Bookmark::class); }
    public function reports() { return $this->hasMany(Report::class); }
    public function readingHistories() { return $this->hasMany(ReadingHistory::class); }
}
