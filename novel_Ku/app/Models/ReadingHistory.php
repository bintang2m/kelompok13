<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReadingHistory extends Model
{
    protected $fillable = ['user_id', 'novel_id', 'chapter_id', 'last_read_at'];

    protected function casts(): array
    {
        return [
            'last_read_at' => 'datetime',
        ];
    }

    public function user() { return $this->belongsTo(User::class); }
    public function novel() { return $this->belongsTo(Novel::class); }
    public function chapter() { return $this->belongsTo(Chapter::class); }
}
