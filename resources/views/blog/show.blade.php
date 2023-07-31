<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>

<body>
	<a href={{ route('blog.edit', $post->id) }} class="italic text-green-500 border-b-1 border-green-400">Edit</a>

	<a href={{ route('blog.index') }}>Return to Blog Lists</a>
	<h1>{{ $post->title }}</h1>
	<img src="{{ $post->image_path }}" alt='img/{{ $post->id }}'>
	<p>{{ $post->body }}</p>
</body>

</html>
