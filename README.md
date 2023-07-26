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

Progress
