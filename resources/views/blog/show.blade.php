<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="{{ $post->meta->meta_description ? $post->meta->meta_description : '' }}">
	<meta name="keyword" content="{{ $post->meta->meta_keyword ? $post->meta->meta_keyword : '' }}">
	<meta name="robots" content="{{ $post->meta->meta_robots ? $post->meta->meta_robots : '' }}">
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
