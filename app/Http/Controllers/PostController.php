<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
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
	public function store(Request $request) {

		Post::create([
			'title' => $request->title,
			'excerpt' => $request->excerpt,
			'body' => $request->body,
			'image_path' => $this->storeImage($request),
			'is_published' => $request->is_published === 'on',
			'min_to_read' => $request->min_to_read
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
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		//
	}

	private function storeImage($request) {
		$newImageName = uniqid() . '-' . $request->title . '.' . $request->image->extension();

		return $request->image->move(public_path('images', $newImageName));
	}
}
