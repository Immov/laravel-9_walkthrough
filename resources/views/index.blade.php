<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>

<body>
	<h1>This is index [Invoke]</h1>
	<a href={{ route('blog.index') }}>Blog</a> <br>
	<a href={{ route('blog.show', ['id' => 1]) }}>Blog-1</a>

</body>

</html>
