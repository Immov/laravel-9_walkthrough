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
