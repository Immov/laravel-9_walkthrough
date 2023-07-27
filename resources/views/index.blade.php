<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	<title>Document</title>
</head>

<body>
	<h1 class="text-3xl p-2 font-bold">
		Tailwind Text
	</h1>
	<a href={{ route('blog.index') }}>View Blogs</a><br>
	<a href={{ route('blog.create') }}>Create Blog</a>

</body>

</html>
