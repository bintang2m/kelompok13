<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'avatar', 'bio',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function novels() { return $this->hasMany(Novel::class); }
    public function comments() { return $this->hasMany(Comment::class); }
    public function commentLikes() { return $this->hasMany(CommentLike::class); }
    public function reviews() { return $this->hasMany(Review::class); }
    public function bookmarks() { return $this->hasMany(Bookmark::class); }
    public function reports() { return $this->hasMany(Report::class); }
    public function readingHistories() { return $this->hasMany(ReadingHistory::class); }
    public function notifications() { return $this->hasMany(Notification::class); }
}
