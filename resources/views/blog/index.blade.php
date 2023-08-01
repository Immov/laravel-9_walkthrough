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

	@if (session()->has('message'))
		<div class="mx-auto w-4/5 pb-10">
			<div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
				{{ session()->get('message') }}
			</div>
		</div>
	@endif

	@if (Auth::user())
		<a href={{ route('blog.create') }}>Create Blog</a>
	@endif

	<ol>
		@forelse ($posts as $post)
			<li>{{ $loop->iteration }}
				<a href={{ route('blog.show', $post->id) }}>{{ $post->title }}</a>
				- Made by: <a href="">{{ $post->user->name }}</a> on {{ $post->updated_at->format('d/m/Y') }}

				@if (Auth::id() == $post->user->id)
					<a href={{ route('blog.edit', $post->id) }} class="italic text-green-500 border-b-1 border-green-400">Edit</a>
					<form action="{{ route('blog.destroy', $post->id) }}" method="POST">
						@csrf
						@method('DELETE')
						<button class="pt-3 text-red-500 pr-3" type="submit">Delete</button>
					</form>
				@endif
			</li>
		@empty
			<li>No post have been made</li>
		@endforelse
	</ol>

</body>

</html>
