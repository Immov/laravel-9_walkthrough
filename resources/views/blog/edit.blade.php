<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
	<h1>Edit: {{ $post->title }}</h1>

	<div>
		<div class="pb-8">

			@if ($errors->any())
				<div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
					Something went wrong
				</div>
				<ul class="border border-t-0 border-red-400, rounded-b bg-red-100 px-4 py-2 text-red-700">
					@foreach ($errors->all() as $error)
						<li>
							{{ $error }}
						</li>
					@endforeach
				</ul>
			@endif
		</div>
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
				<label for="image_path">Select a file <input type="file" name="image_path"></label>

			</div>
			<button type="submit">Edit Post</button>
		</form>
	</div>
</body>

</html>
