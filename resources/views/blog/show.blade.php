<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>

<body>

	<a href={{ route('blog.index') }}>Return to Blog Lists</a>
	<h1>{{ $post->title }}</h1>
	<img src="{{ $post->image_path }}" alt='img/{{ $post->id }}'>
	<p>{{ $post->body }}</p>
</body>

</html>
