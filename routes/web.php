<?php

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

// GET
Route::get('/blog', [PostController::class, 'index'])
	->name('blog.index'); // a href ={{ route('blog.index') }}
Route::get("/blog/{id}", [PostController::class, 'show'])
	->name('blog.show'); // route('blog.show', ['id' => 1])


// POST
Route::get('/blog/create', [PostController::class, 'create'])
	->name('blog.create');
Route::post('/blog', [PostController::class, 'store'])
	->name('blog.store');

// PUT or PATCH
Route::get('/blog/edit/{id}', [PostController::class, 'edit'])
	->name('blog.edit');
Route::patch('/blog/{id}', [PostController::class, 'update'])
	->name('blog.update');

// DELETE
Route::delete('/blog/{id}', [PostController::class, 'destroy'])
	->name('blog.destroy');




// Route for invoke method (No need to put function name after HomeController::class) --> Good for Single function controller
Route::get('/', HomeController::class);





// ==========NOTES==========

/*	Route Resource
	// Includes all the methods(index, show, create, store, edit, update, destroy)
	// Also have a premade names like blog.index, blog.destroy, etc
	// Route::resource('blog', PostController::class);
*/

// Return view
// Route::view('/blog', 'blog.index', ['name' => 'Immov']);

/*	REGEX for parameter
	Route::get('/blog/{id?}/{name?}', [PostController::class, 'show'])
	->where([
		'id' => '[0-9]+', // or use ->whereNumber('id')
		'name' => '[A-Za-z]+' // or use ->whereAlpha('name')
	]); */

/*	OR
	Route::get('/blog/{id}/{name}', [PostController::class, 'index'])
	->whereNumber('id')
	->whereAlpha('name');
 */


// Multiple HTTP verbs

// Route any methods inside [], in this case GET and POST, to run index on PostController
// Route::match(['GET', 'POST'], '/blog', [PostController::class, 'index']);

// Route ANY methods of /blog, to run index on PostController
// Route::any('/blog', [PostController::class, 'index']);
