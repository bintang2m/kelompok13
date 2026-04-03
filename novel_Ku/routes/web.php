<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\NovelController;
use App\Http\Controllers\Web\ChapterController;
use App\Http\Controllers\Web\CommentController;
use App\Http\Controllers\Web\ReviewController;
use App\Http\Controllers\Web\BookmarkController;
use App\Http\Controllers\Web\ReportController;
use App\Http\Controllers\Web\NotificationController;
use App\Http\Controllers\Web\ExploreController;
use App\Http\Controllers\Web\StatisticController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\NovelController as AdminNovelController;
use App\Http\Controllers\Admin\GenreController as AdminGenreController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;

// Public Routes (Guest & Auth)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/novels', [ExploreController::class, 'index'])->name('novels.index');
Route::get('/novels/{novel}', [NovelController::class, 'show'])->name('novels.show');
Route::get('/novels/{novel}/chapters/{chapter}', [ChapterController::class, 'show'])->name('chapters.show');
Route::get('/users/{user}', [\App\Http\Controllers\Web\UserProfileController::class, 'show'])->name('users.show');

// Authenticated User Routes (Reader & Writer)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        $totalNovels = $user->novels()->count();
        $totalViews = $user->novels()->sum('views');
        $bookmarksCount = $user->bookmarks()->count();
        $recentNovels = $user->novels()->orderBy('created_at', 'desc')->take(4)->get();
        return view('dashboard', compact('user', 'totalNovels', 'totalViews', 'bookmarksCount', 'recentNovels'));
    })->name('dashboard');

    // Profile (Breeze default)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Platform Features
    Route::post('/novels/{novel}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/novels/{novel}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::post('/novels/{novel}/bookmarks', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');
    Route::post('/report', [ReportController::class, 'store'])->name('report.store');
    
    // Inbox Notifications
    Route::get('/inbox', [NotificationController::class, 'index'])->name('inbox.index');
    Route::post('/inbox/{id}/read', [NotificationController::class, 'read'])->name('inbox.read');
    
    // Bookmarks & History
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::get('/history', [\App\Http\Controllers\Web\HistoryController::class, 'index'])->name('history.index');
    
    // Statistics
    Route::get('/statistics', [StatisticController::class, 'index'])->name('statistics.index');

    // Writer Features (Management)
    Route::prefix('writer')->name('writer.')->group(function () {
        Route::resource('novels', NovelController::class)->except(['show']);
        Route::resource('novels.chapters', ChapterController::class)->except(['show']);
    });
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('users', AdminUserController::class);
    Route::resource('genres', AdminGenreController::class);
    Route::resource('novels', AdminNovelController::class);
    Route::resource('reports', AdminReportController::class);
    Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class);
});

require __DIR__.'/auth.php';
