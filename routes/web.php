<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TweetController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/dashboard', fn () => Inertia\Inertia::render('Dashboard'))->name('dashboard');

    Route::get('/tweets', [TweetController::class, 'index'])->name('tweets.index');
    Route::post('/tweets', [TweetController::class, 'store'])->name('tweets.store');

    Route::get('/profile/{user:name}', [TweetController::class, 'profile'])->name('tweets.profile');

    Route::get('/followings', [TweetController::class, 'followings'])->name('tweets.followings');
    Route::post('/unfollows/{user:id}', [TweetController::class, 'unfollows'])->name('tweets.followings.store');
    Route::post('/follows/{user:id}', [TweetController::class, 'follows'])->name('tweets.followings.store');
});
