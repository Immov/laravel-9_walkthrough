<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>

<body>
	<a href={{ route('home.home') }}>Return to Homepage</a>
	<ol>
		@forelse ($posts as $post)
			<li>{{ $loop->iteration }}
				<a href={{ route('blog.show', $post->id) }}>{{ $post->title }}</a>
			</li>
		@empty
			<li>No post have been made</li>
		@endforelse
	</ol>

</body>

</html>
