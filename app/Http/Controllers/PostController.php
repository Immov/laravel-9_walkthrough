<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostFormRequest;
use App\Models\Post;
use App\Models\PostMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {

		$posts = Post::orderBy('id', 'asc')->get();

		return view('blog.index', [
			'posts' => $posts,
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view('blog.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(PostFormRequest $request) {
		$request->validated();

		$post = Post::create([
			'user_id' => Auth::id(),
			'title' => $request->title,
			'excerpt' => $request->excerpt,
			'body' => $request->body,
			'image_path' => $this->storeImage($request),
			'is_published' => $request->is_published === 'on',
			'min_to_read' => $request->min_to_read
		]);

		$post->meta()->create([
			'post_id' => $post->id,
			'meta_description' => $request->meta_description,
			'meta_keyword' => $request->meta_keyword,
			'meta_robots' => $request->meta_robots
		]);

		return redirect(route('blog.index'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id = 1) {
		$post = Post::findOrFail($id);
		return view('blog.show', [
			'post' => $post
		]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$post = Post::where('id', $id)->first();
		$post_meta = PostMeta::where('post_id', $id)->first();
		return view('blog.edit', [
			'post' => $post,
			'post_meta' => $post_meta
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(PostFormRequest $request, $id) {
		$request->validated();

		$data = $request->except(['_token', '_method', 'meta_description', 'meta_keyword', 'meta_robots']);
		$data['is_published'] = $request->has('is_published'); // Convert checkbox value to bool

		if ($request->hasFile('image_path')) {
			$imagePath = $this->storeImage($request);
			$data['image_path'] = $imagePath;
		}

		$data_meta = $request->except(['_token', '_method', 'title', 'excerpt', 'min_to_read', 'body']);

		Post::where('id', $id)->update($data);
		PostMeta::where('post_id', $id)->update($data_meta);

		return redirect(route('blog.index'));
		/* 	Bad method (all field must have values)
			Post::where('id', $id)->update([
			'title' => $request->title,
			'excerpt' => $request->excerpt,
			'body' => $request->body,
			'image_path' => $request->image,
			'is_published' => $request->is_published === 'on',
			'min_to_read' => $request->min_to_read
		]); */
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		Post::destroy($id);

		return redirect(route('blog.index'))->with('message', 'Post has been deleted');
	}

	private function storeImage($request) {
		$newImageName = uniqid() . '-' . $request->title . '.' . $request->image_path->extension();
		$request->image_path->move(public_path('images'), $newImageName);
		return '/images/' . $newImageName;
	}
}
