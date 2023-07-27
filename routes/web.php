<?php

use App\Http\Controllers\FallbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/*	| Web Routes
	| Here is where you can register web routes for your application. These
	| routes are loaded by the RouteServiceProvider within a group which
	| contains the "web" middleware group. Now create something great!
	|
*/

/*	HTTP Methods:
	GET - Request a resource
	PUT - Update a resource (Modify every single values)
	PATCH - Modify a resource (Onlymodifies the values that have been changed)
	DELETE - Delete a resource
	OPTIONS - Ask the server which verbs are allowed
*/

// Route::get('/blog/create', [PostController::class, 'create'])->name('create.create');

// Route::resource('/blog', PostController::class);

//Route Nesting
Route::prefix('/blog')
	->group(function () {
		// GET
		Route::get('/', [PostController::class, 'index'])->name('blog.index'); // a href ={{ route('blog.index') }}
		Route::get("/{id}", [PostController::class, 'show'])->name('blog.show'); // route('blog.show', ['id' => 1])

		// POST
		Route::get('/create', [PostController::class, 'create'])->name('blog.create'); // <-- This should be a POST request
		Route::post('/create', [PostController::class, 'store'])->name('blog.store'); // <-- Use POST for creating a new blog post

		// PUT or PATCH
		Route::get('/edit/{id}', [PostController::class, 'edit'])->name('blog.edit');
		Route::patch('/{id}', [PostController::class, 'update'])->name('blog.update');

		// DELETE
		Route::delete('/{id}', [PostController::class, 'destroy'])->name('blog.destroy');
	});


// Route for invoke method (No need to put function name after HomeController::class) --> Good for Single function controller
Route::get('/', HomeController::class)->name('home.home');


// Fallback Route, like app.get('/*') on expressJs
Route::fallback(FallbackController::class);
