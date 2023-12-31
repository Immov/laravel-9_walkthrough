<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FallbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;

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

// Route for invoke method (No need to put function name after HomeController::class) --> Good for Single function controller
Route::get('/', HomeController::class)->name('home.home');

// Route::get('/', function () {
// 	return view('welcome');
// });

Route::get('/dashboard', function () {
	return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';


//Route Nesting
Route::prefix('/blog')
	->group(function () {
		// GET
		Route::get('/', [PostController::class, 'index'])->name('blog.index'); // a href ={{ route('blog.index') }}
		Route::get("/{id}", [PostController::class, 'show'])->name('blog.show')->whereNumber('id'); // route('blog.show', ['id' => 1])

		// POST
		Route::get('/create', [PostController::class, 'create'])->name('blog.create'); // <-- This should be a POST request
		Route::post('/', [PostController::class, 'store'])->name('blog.store'); // <-- Use POST for creating a new blog post

		// PUT or PATCH
		Route::get('/edit/{id}', [PostController::class, 'edit'])->name('blog.edit')->whereNumber('id');
		Route::patch('/{id}', [PostController::class, 'update'])->name('blog.update')->whereNumber('id');

		// DELETE
		Route::delete('/{id}', [PostController::class, 'destroy'])->name('blog.destroy')->whereNumber('id');
	});





// Fallback Route, like app.get('/*') on expressJs
Route::fallback(FallbackController::class);
