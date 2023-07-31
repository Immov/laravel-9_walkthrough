# How to clone laravel project

`git clone [link]`
`composer install`
`npm install`
`cp .env.example .env` --> or copy the orignal .env file
Change DB on .en file
`php artisan key:generate`
`php artisan migrate`
`php artisan serve`

# Laravel 9 Tutorial

[Source](https://youtube.com/playlist?list=PLFHz2csJcgk_mM2jEf7t8P678O_jz83on)

`php artisan make:controller asdaController --resource` --> Create a controller with premade functions

# Routes NOTES

## Route Resource

Includes all the methods(index, show, create, store, edit, update, destroy)
Also have a premade names like blog.index, blog.destroy, etc
`Route::resource('blog', PostController::class);`

## Return view

`Route::view('/blog', 'blog.index', ['name' => 'Immov']);`

## REGEX for parameter

```php
Route::get('/blog/{id?}/{name?}', [PostController::class, 'show'])
->where([
'id' => '[0-9]+', // or use ->whereNumber('id')
'name' => '[A-Za-z]+' // or use ->whereAlpha('name')
]);
```

OR

```php
Route::get('/blog/{id}/{name}', [PostController::class, 'index'])
->whereNumber('id')
->whereAlpha('name');
```

## Multiple HTTP verbs

### Route any methods inside [], in this case GET and POST, to run index on PostController

`Route::match(['GET', 'POST'], '/blog', [PostController::class, 'index']);`

### Route ANY methods of /blog, to run index on PostController

`Route::any('/blog', [PostController::class, 'index']);`

## Laravel Blade links

```php
@forelse ($posts as $post)
	<li>{{ $loop->iteration }}
		<a href={{ route('blog.show', $post->id) }}>{{ $post->title }}</a>
	</li>
@empty
	<li>No post have been made</li>
@endforelse
```

# DB Notes

## Check DB Connection

`php artisan tinker`

`DB::connection()->getPdo();`

## Migration

`php artisan make:migration create_posts_table`

```php
public function up() {
	Schema::create('posts', function (Blueprint $table) {
		$table->id(); // Set as primary Key $table->id()->primary();
		$table->string('title')->unique();
		$table->text('exerpt')->nullable(); // Can be null (DEFAULT NULL)
		$table->text('body');
		$table->integer('min_to_read')->default(1);
		$table->string('image_path')->nullable();
		$table->boolean('is_published')->default(false);
		$table->timestamps();
	});
}
```

`php artisan migrate`

`php artisan migrate:status`

`php artisan migrate:reset` --> Rollback

`php artisan migrate:refresh` --> Rollback and migrate again

## Seeder

To make a mockup data

`php artisan make:seeder PostTableSeeder`
`php artisan make:model Post`

Run seeder
`php artisan migrate --seed`

## Model Factories

To make a mockup data template
`php artisan make:factory PostFactory`

Syntax

```php
return [
	'title' => 'Model Factories',
	'excerpt' => 'Excerpt of our first model factory',
	'body' => 'Content of body',
	'image_path' => 'Image Path',
	'is_published' => 1,
	'min_to_read' => 2
];
```

Template using faker

```php
return [
	'title' => $this->faker->unique->sentence(),
	'excerpt' => $this->faker->realText($maxNbChars = 50), // Max Char
	'body' => $this->faker->text(),
	'image_path' => $this->faker->imageUrl(640, 480), //Width and Height
	'is_published' => 1,
	'min_to_read' => $this->faker->numberBetween(1, 10)
];
```

`php artisan db:seed`

## Query Builder

index function on controller

SELECT queries

```php
public function index() {

	//Select
	$posts = DB::select('SELECT * FROM posts WHERE id = 1');
	$posts = DB::select('SELECT * FROM posts WHERE id = ?', [1]);
	$posts = DB::select('SELECT * FROM posts WHERE id = :id', ['id' => 1]);

	// Insert
	$posts = DB::insert('INSERT INTO posts (title, excerpt, body, image_path, is_published, min_to_read)
	VALUES(?, ?, ?, ?, ?, ?)',
	['Test', 'Test', 'Test', 'test', true, 1]);

	// Update
	$posts = DB::update('UPDATE posts set body = ? where id = ?', ['Body 2', 201]);

	// Delete
	$posts = DB::delete('DELETE FROM posts where id = ?', [201]);

	// Method chaining ->get()
	$posts = DB::table('posts')->get();

	$posts = DB::table('posts')
			->select('title')  // specify the column to be selected
			->get();

	// Method chainings
	$posts = DB::table('posts')
		->where('id', 50) // WHERE ID == 50
		->where('id', '>', 50) // WHERE ID > 50
		->whereBetween('min_to_read', [2, 6]) // where min to read is between 2 and 6 (inclusive)
		->whereNotBetween('min_to_read', [2, 6]) // where the value is not 2 until 6
		->whereIn('min_to_read', [2, 6, 10]) // where the value is 2 or 6 or 10
		->whereNull('excerpt') // select a null value
		->whereNotNull('excerpt') // select a valut without a null on excerpt
		// Select a unique value on min_to_read column, no duplicates
		->select('min_to_read')
		->distinct()
		->orderBy('id', 'desc') // Sort descending
		->inRandomOrder() // Sort in random order
		// Skips the first 20 datas and select only 5 data after 20
		->skip(20)
		->take(5)
		->find(100); // find where PRIMARY key == 100
		// Returns the  value of 'body'of the first query where min_to_read == 5
		->where('min_to_read', 5)
		->value('body');
		// Counts how many data that min_to_read == 5
		->where('min_to_read', 5)
		->count();
		// Statistics
		->min('min_to_read'); // Returns min('min_to_read)
		->max('min_to_read'); // min max sum avg, self explanatory
		->sum('min_to_read');
		->avg('min_to_read');



		->get(); //selects all data
		->first(); // select only the first query

	var_dump($posts);

	return view('blog.index', ['name' => 'Immov']);
}

```

## Front End (TailwindCSS)

Install dependencies
`npm i -D tailwindcss postcss autoprefixer`

Initialixe tailwindcss config (Not required)
`npx tailwindcss init`

1. Create config and specifies the directory of where to look the html files

-   tailwind.config.js
    ```js
    /** @type {import('tailwindcss').Config} */
    module.exports = {
    	content: ["./resources/**/*.blade.php"],
    	theme: {
    		extend: {},
    	},
    	plugins: [],
    };
    ```

2. Add Tailwind css to webpack.mix.js

    ```js
    mix.js("resources/js/app.js", "public/js").postCss(
    	// files inside resource/js/app.js will be compiled to public/js
    	"resources/css/app.css",
    	"public/css",
    	[require("tailwindcss")]
    );
    ```

3. Compile the front end
   `npm run watch` --> run `npm run build` everytime we save our view

## Laravel Variables

PostController

```php
return view('blog.index', [
	'posts' => DB::table('posts')->get(), // SELECT * FROM POSTS
]);
```

```php
@forelse ($posts as $post)
	{{ $post->id }}. {{ $post->title }} <br>
@empty
	<p>No postst have beed set</p> // will be shown if $posts ==
@endforelse
```

### Hidden variables

```php
$loop->index // starts from 0
$loop->iteration // starts from 1
$loop->remaining // shows the remaining items to be shown (kinda like descending)
$loop->count // returns the number of items that are being looped
$loop->first // returns true if it's the first item in the loop
$loop->last // returns true if it's the last item in the loop
$loop->depth // returns how many loop is being used, if nested loop like for loop inside for loop, will return 2
$loop->parent // reference to the i loop if the loop is nested like for i, with for j inside
```

## Eloquent Model Conventions

Make model
`php artisan make:model Post`

### Post.php on models configs

```php
protected $table = 'posts'; // which table for this model
protected $primaryKey = 'title'; // define the prefered primary key
protected $timestamps = false; // disable the timestamps table rather than deleting it
protected $dateTime = 'U'; // only stores the seconds over time stamps

protected $connection = 'sqlite'; // for using multiple drivers for specific model
protected $attributes = [
	'is_published' => true,
]; // for defining the default value
```

### Retrieve data using eloquent

```php
$posts = Post::all(); // select all, can't use method chaining
$posts = Post::orderBy('id', 'desc')->take(5)->get(); // can add method chaining
$posts = Post::where('min_to_read', '!=', '5')->get(); // where not equal to 5

// Chunks
Post::chunk(25, function($posts) {
	foreach($posts as $post) {
		echo $post->title . '<br>';
	}
});

// Min max avg
$posts = Post::get()->count(); // returns how many datas
$posts = Post::sum('min_to_read'); // returns the sum of all min_to_read data
$posts = Post::avg('min_to_read');


public function show($id = 1) { // shows a single data
		$posts = Post::findOrFail($id); // safer than Post::find()
		return view('blog.index', [
			'posts' => $posts
		]);
	}
```

### Insert data using eloquent

Form inside blade.php

```html
<form
	action="{{ route('blog.store') }}"
	method="POST"
	enctype="multipart/form-data"
>
	@csrf
	<div>
		<label for="is_published">Is Published</label>
		<input type="checkbox" name="is_published" />
	</div>
	<div>
		<label for="title">Title</label>
		<input type="text" name="title" placeholder="Title" />
	</div>
	<div>
		<label for="excerpt">Excerpt</label>
		<input type="text" name="excerpt" placeholder="Excerpt" />
	</div>
	<div>
		<label for="min_to_read">Minutes to read</label>
		<input type="number" name="min_to_read" placeholder="5 Minutes" />
	</div>
	<div>
		<label for="body">Content</label>
		<textarea
			name="body"
			cols="30"
			rows="10"
			placeholder="Contents..."
		></textarea>
	</div>
	<div>
		<label for="image">Select a file</label>
		<input type="file" name="image" />
	</div>
	<button type="submit">Submit Post</button>
</form>
```

PostController.php
OOP PHP:

```php
public function store(Request $request) {
	$data = $request->all(); // method to retrieve all data from the post
	dd($data);

	exit; // immediately return, does not execute the code below

	$post = new Post(); // create a post object
	$post->title = $request->title;
	$post->excerpt = $request->excerpt;
	$post->body = $request->body;
	$post->image_path = $request->image_path;
	$post->is_published = $request->is_published === 'on'; // if the value is on, return true
	$post->min_to_read = $request->min_to_read;
	$post->save(); // save to the database
	return redirect(route('blog.index')); // Redirects to blog.index
	}
```

Eloquent PHP:

```php
public function store(Request $request) {
	Post::create([
		'title' => $request->title,
		'excerpt' => $request->excerpt,
		'body' => $request->body,
		'image_path' => $request->image_path,
		'is_published' => $request->is_published === 'on',
		'min_to_read' => $request->min_to_read
	]);
	return redirect(route('blog.index'));
}
```

models/Post.php

```php
class Post extends Model {
	protected $fillable = [
		'title', 'excerpt', 'body', 'image_path', 'is_published', 'min_to_read'
	]; // prevents unwanted insertion of unintendent values
	use HasFactory;
}
```

Progress

### Image Upload

Function to upload the image

```php
private function storeImage($request) {
		$newImageName = uniqid() . '-' . $request->title . '.' . $request->image->extension();
		$request->image->move(public_path('images'), $newImageName); // stores the image
		return '/images/' . $newImageName; // returns the path ro public.images
	}


// Original, from video. Doesn't work
private function storeImage($request) {
	$newImageName = uniqid() . '-' . $request->title . '.' . $request->image->extension();
	// asda-[title].png

	return $request->image->move(public_path('images', $newImageName)); //save the image to public/images witn the name $newImageName
}
```

### Update data using eloquent

edit.blade.php

```php
<form action="{{ route('blog.update', $post->id) }}" method="POST" enctype="multipart/form-data">
	@csrf
	@method('PATCH')
	<div>
		<label for="is_published">Is Published</label>
		<input type="checkbox" {{ $post->is_published ? 'checked' : '' }} name="is_published" value="true">
	</div>
	<div>
		<label for="title">Title</label>
		<input type="text" name="title" placeholder="Title" value="{{ $post->title }}">
	</div>
	<div>
		<label for="excerpt">Excerpt</label>
		<input type="text" name="excerpt" placeholder="Excerpt" value="{{ $post->excerpt }}">
	</div>
	<div>
		<label for="min_to_read">Minutes to read</label>
		<input type="number" name="min_to_read" placeholder="5 Minutes" value="{{ $post->min_to_read }}">
	</div>
	<div>
		<label for="body">Content</label>
		<textarea name="body" cols="30" rows="10">{{ $post->body }}</textarea>
	</div>
	<div>
		<label for="image">Select a file <input type="file" name="image"></label>

	</div>
<button type="submit">Edit Post</button>
</form>
```

PostController.php

```php
public function edit($id) {
		$post = Post::where('id', $id)->first();
		return view('blog.edit', [
			'post' => $post
		]);
	}

public function update(Request $request, $id) {
	$request->validate([
		'title' => 'required|max:255|unique:posts,title,' . $id,
		'excerpt' => 'required',
		'body' => 'required',
		'image_path' => ['mimes:png,jpg, jpeg', 'max:5048'],
		'min_to_read' => 'min:0|max:60'

	]);

	$post = Post::findOrFail($id);

	$data = $request->except(['_token', '_method']);
	$data['is_published'] = $request->has('is_published'); // Convert checkbox value to bool

	if ($request->hasFile('image_path')) {
		$imagePath = $this->storeImage($request);
		$data['image_path'] = $imagePath;
	}

	Post::where('id', $id)->update($data);
	return redirect(route('blog.index'));
	/* 	Bad method (all field must have values)
		Post::where('id', $id)->update([
		'title' => $request->title,
		'excerpt' => $request->excerpt,
		'body' => $request->body,
		'image_path' => $request->image,
		'is_published' => $request->is_published === 'on',
		'min_to_read' => $request->min_to_read
	]); */
}
```

### Form Validation & Displaying Error Messages

PostController

```php
public function store(Request $request) {
	$request->validate([
		'title' => 'required|unique:posts|max:255',
		'excerpt' => 'required',
		'body' => 'required',
		'image' => ['required', 'mimes:png,jpg, jpeg', 'max:5048'],
		// 'is_published' => '', true/false, no rules necessary
		'min_to_read' => 'min:0|max:60'
	]);

	Post::create([
		'title' => $request->title,
		'excerpt' => $request->excerpt,
		'body' => $request->body,
		'image_path' => $this->storeImage($request),
		'is_published' => $request->is_published === 'on',
		'min_to_read' => $request->min_to_read
	]);
	return redirect(route('blog.index'));
}
```

```html
@if ($errors->any())
<div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
	Something went wrong
</div>
<ul
	class="border border-t-0 border-red-400, rounded-b bg-red-100 px-4 py-2 text-red-700"
>
	@foreach ($errors->all() as $error)
	<li>{{ $error }}</li>
	@endforeach
</ul>
@endif
```

### Delete data using eloquent

index.blade.php

```php
@if (session()->has('message'))
	<div class="mx-auto w-4/5 pb-10">
		<div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
			{{ session()->get('message') }}
		</div>
	</div>
@endif
```

PostController.php

```php
public function destroy($id) {
	Post::destroy($id);

	return redirect(route('blog.index'))->with('message', 'Post has been deleted');
}
```

## How to use Form Requests in Laravel

Use form requests in Laravel to prevent duplication when working with form validation

Create form request
`php artisan make:request PostFormRequest`

PostFormRequest.php

```php
public function authorize() {
	return true;
}

public function rules() {
	$rules = [
		'title' => 'required|max:255|unique:posts,title,' . $this->id,
		'excerpt' => 'required',
		'body' => 'required',
		'image_path' => ['mimes:png,jpg, jpeg', 'max:5048'],
		'min_to_read' => 'min:0|max:60'
	];
	if (in_array($this->method(), ['POST'])) {
		$rules['image_path'] =  ['required', 'mimes:png,jpg, jpeg', 'max:5048'];
	}

	return $rules;
}
```

PostController.php

```php
public function update(PostFormRequest $request, $id) {
		$request->validated();
}

public function store(PostFormRequest $request) {
		$request->validated();
}
```

## Laravel Relationships

### One to Many Relationship

`composer update`
`composer require laravel/breeze:1.7.0 --dev` Safest option
create `welcome.blade.php`
Backup `web.php` before running the command below
run `php artisan breeze:install`
`npm install && npm run dev`

Restructure Post Migration

create_posts_table.php

```php
$table->unsignedBigInteger('user_id');
/*
other column configs
*/
$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
```

PostFactory.php

```php
'user_id' => 1
```

`php artisan migrate:refresh`

Models/User.php

```php
public function posts(){
	return $this->hasMany(Post::class);
}
```

dashboard.blade.php

```php
<h1 class="text-xl font-bold pt-8 pb-2">
	Posts of: {{ Auth::user()->name }}

	@foreach(Auth::user()->posts as $post)
		<h2>
		{{ $post->title }}
		</h2>
	@endforeach
</h1>
```

Models/Post.php

```php
public function user(){
	return $this->belongsTo(User::class);
}
```

blog/index.blade.php

```php
<a href="{{ route('blog.show', $post->id) }}">{{ $post->title }}</a>
- Made by: <a href="">{{ $post->user->name }}</a> on {{ $post->updated_at->format('d/m/Y') }}
```

### One to One Relationship

`php artisan make:model PostMeta -m`

migration/create_post_meta_table.php

```php
public functio up(){
	Schema::create('post', function (Blueprint $table) {
		$table->id();
		$table->unsignedBigInteger('post_id');
		$table->string('meta_description');
		$table->string('meta_keyword');
		$table->string('meta_robots');
		$table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
		$table->timestamps();
	});
}
```

`php artisan migrate`

Models/Post.php

```php
	public function meta(){
		return $this->hasOne(PostMeta::class);
	}
```

### Many to many Relationship

## Authentication
