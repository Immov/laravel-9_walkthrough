<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>

<body>

	@forelse ($posts as $post)
		{{ $loop->index }}. {{ $post->title }} <br>
	@empty
		<p>No postst have beed set</p>
	@endforelse

</body>

</html>
