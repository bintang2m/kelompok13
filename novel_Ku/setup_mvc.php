<?php
$base = __DIR__;

$models = [
    'User' => "<?php\n\nnamespace App\Models;\n\nuse Illuminate\Database\Eloquent\Factories\HasFactory;\nuse Illuminate\Foundation\Auth\User as Authenticatable;\nuse Illuminate\Notifications\Notifiable;\n\nclass User extends Authenticatable\n{\n    use HasFactory, Notifiable;\n\n    protected \$fillable = [\n        'name', 'email', 'password', 'role', 'avatar',\n    ];\n\n    protected \$hidden = [\n        'password', 'remember_token',\n    ];\n\n    protected function casts(): array\n    {\n        return [\n            'email_verified_at' => 'datetime',\n            'password' => 'hashed',\n        ];\n    }\n\n    public function novels() { return \$this->hasMany(Novel::class); }\n    public function comments() { return \$this->hasMany(Comment::class); }\n    public function commentLikes() { return \$this->hasMany(CommentLike::class); }\n    public function reviews() { return \$this->hasMany(Review::class); }\n    public function bookmarks() { return \$this->hasMany(Bookmark::class); }\n    public function reports() { return \$this->hasMany(Report::class); }\n    public function readingHistories() { return \$this->hasMany(ReadingHistory::class); }\n    public function notifications() { return \$this->hasMany(Notification::class); }\n}\n",
    
    'Novel' => "<?php\n\nnamespace App\Models;\n\nuse Illuminate\Database\Eloquent\Model;\n\nclass Novel extends Model\n{\n    protected \$fillable = ['user_id', 'title', 'description', 'cover', 'status', 'publish_status', 'views'];\n\n    public function author() { return \$this->belongsTo(User::class, 'user_id'); }\n    public function chapters() { return \$this->hasMany(Chapter::class); }\n    public function genres() { return \$this->belongsToMany(Genre::class, 'novel_genre'); }\n    public function comments() { return \$this->hasMany(Comment::class); }\n    public function reviews() { return \$this->hasMany(Review::class); }\n    public function bookmarks() { return \$this->hasMany(Bookmark::class); }\n    public function reports() { return \$this->hasMany(Report::class); }\n    public function readingHistories() { return \$this->hasMany(ReadingHistory::class); }\n}\n",
    
    'Chapter' => "<?php\n\nnamespace App\Models;\n\nuse Illuminate\Database\Eloquent\Model;\n\nclass Chapter extends Model\n{\n    protected \$fillable = ['novel_id', 'title', 'content', 'chapter_number', 'views', 'publish_status'];\n\n    public function novel() { return \$this->belongsTo(Novel::class); }\n    public function comments() { return \$this->hasMany(Comment::class); }\n    public function readingHistories() { return \$this->hasMany(ReadingHistory::class); }\n}\n",

    'Genre' => "<?php\n\nnamespace App\Models;\n\nuse Illuminate\Database\Eloquent\Model;\n\nclass Genre extends Model\n{\n    protected \$fillable = ['name'];\n\n    public function novels() { return \$this->belongsToMany(Novel::class, 'novel_genre'); }\n}\n",

    'Comment' => "<?php\n\nnamespace App\Models;\n\nuse Illuminate\Database\Eloquent\Model;\n\nclass Comment extends Model\n{\n    protected \$fillable = ['user_id', 'novel_id', 'chapter_id', 'parent_id', 'content'];\n\n    public function user() { return \$this->belongsTo(User::class); }\n    public function novel() { return \$this->belongsTo(Novel::class); }\n    public function chapter() { return \$this->belongsTo(Chapter::class); }\n    public function parent() { return \$this->belongsTo(Comment::class, 'parent_id'); }\n    public function replies() { return \$this->hasMany(Comment::class, 'parent_id'); }\n    public function likes() { return \$this->hasMany(CommentLike::class); }\n    public function reports() { return \$this->hasMany(Report::class); }\n}\n",

    'CommentLike' => "<?php\n\nnamespace App\Models;\n\nuse Illuminate\Database\Eloquent\Model;\n\nclass CommentLike extends Model\n{\n    protected \$fillable = ['user_id', 'comment_id'];\n\n    public function user() { return \$this->belongsTo(User::class); }\n    public function comment() { return \$this->belongsTo(Comment::class); }\n}\n",

    'Review' => "<?php\n\nnamespace App\Models;\n\nuse Illuminate\Database\Eloquent\Model;\n\nclass Review extends Model\n{\n    protected \$fillable = ['user_id', 'novel_id', 'rating', 'comment'];\n\n    public function user() { return \$this->belongsTo(User::class); }\n    public function novel() { return \$this->belongsTo(Novel::class); }\n}\n",

    'Bookmark' => "<?php\n\nnamespace App\Models;\n\nuse Illuminate\Database\Eloquent\Model;\n\nclass Bookmark extends Model\n{\n    protected \$fillable = ['user_id', 'novel_id'];\n\n    public function user() { return \$this->belongsTo(User::class); }\n    public function novel() { return \$this->belongsTo(Novel::class); }\n}\n",

    'Report' => "<?php\n\nnamespace App\Models;\n\nuse Illuminate\Database\Eloquent\Model;\n\nclass Report extends Model\n{\n    protected \$fillable = ['user_id', 'novel_id', 'comment_id', 'reason', 'status'];\n\n    public function user() { return \$this->belongsTo(User::class); }\n    public function novel() { return \$this->belongsTo(Novel::class); }\n    public function comment() { return \$this->belongsTo(Comment::class); }\n}\n",

    'ReadingHistory' => "<?php\n\nnamespace App\Models;\n\nuse Illuminate\Database\Eloquent\Model;\n\nclass ReadingHistory extends Model\n{\n    protected \$fillable = ['user_id', 'novel_id', 'chapter_id', 'last_read_at'];\n\n    protected function casts(): array\n    {\n        return [\n            'last_read_at' => 'datetime',\n        ];\n    }\n\n    public function user() { return \$this->belongsTo(User::class); }\n    public function novel() { return \$this->belongsTo(Novel::class); }\n    public function chapter() { return \$this->belongsTo(Chapter::class); }\n}\n",

    'Notification' => "<?php\n\nnamespace App\Models;\n\nuse Illuminate\Database\Eloquent\Model;\n\nclass Notification extends Model\n{\n    protected \$fillable = ['user_id', 'title', 'message', 'is_read'];\n\n    public function user() { return \$this->belongsTo(User::class); }\n}\n"
];

foreach ($models as $name => $content) {
    file_put_contents($base . '/app/Models/' . $name . '.php', $content);
}

exec("cd " . escapeshellarg($base) . " && php artisan make:controller Web/NovelController --resource");
exec("cd " . escapeshellarg($base) . " && php artisan make:controller Web/ChapterController --resource");
exec("cd " . escapeshellarg($base) . " && php artisan make:controller Web/CommentController");
exec("cd " . escapeshellarg($base) . " && php artisan make:controller Web/ReviewController");
exec("cd " . escapeshellarg($base) . " && php artisan make:controller Web/BookmarkController");
exec("cd " . escapeshellarg($base) . " && php artisan make:controller Web/ReportController");
exec("cd " . escapeshellarg($base) . " && php artisan make:controller Web/ProfileController");
exec("cd " . escapeshellarg($base) . " && php artisan make:controller Admin/DashboardController");
exec("cd " . escapeshellarg($base) . " && php artisan make:controller Admin/NovelController");
exec("cd " . escapeshellarg($base) . " && php artisan make:controller Admin/GenreController --resource");
exec("cd " . escapeshellarg($base) . " && php artisan make:controller Admin/UserController --resource");
exec("cd " . escapeshellarg($base) . " && php artisan make:controller Admin/ReportController");
exec("cd " . escapeshellarg($base) . " && php artisan make:controller Web/HomeController");

echo "Models updated and Controllers generated successfully.\n";
?>
