<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::get('/dashboard', [\App\Http\Controllers\HomeController::class, 'index'])->middleware(['auth'])->name('dashboard');


Route::get("/p/create", [\App\Http\Controllers\PostsController::class, 'create'])->middleware(['auth'])->name("posts.create");
Route::get("/p/destroy", [\App\Http\Controllers\PostsController::class, 'deletePost'])->middleware(['auth'])->name("posts.destroy");
Route::post("/p", [\App\Http\Controllers\PostsController::class, 'store'])->middleware(['auth']);


Route::get("/p/update/{posts}", [\App\Http\Controllers\PostsController::class, 'update'])->middleware(['auth'])->name('posts.update');
Route::post("/p/post-update", [\App\Http\Controllers\PostsController::class, 'indexUpdate'])->middleware(['auth'])->name('posts.post.update');



Route::get("/p/get", [\App\Http\Controllers\PostsController::class, 'getPost'])->name("post.get");


Route::get('/ajax', [\App\Http\Controllers\PostsController::class, 'PostsResponse'])->name('ajax');
Route::get('/ajax-profile', [\App\Http\Controllers\ProfileController::class, 'ProfileResponse'])->name('ajax_profiles');


Route::get('/profile/{user}', [ProfileController::class, 'index'])->name('profile.show');
Route::post("/follow/{user}", [\App\Http\Controllers\FollowsController::class, "store"])->middleware(['auth'])->name("follow.create");
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('custom_profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
