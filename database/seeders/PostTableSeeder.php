<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$posts = [
			[
				'title' => 'Post One',
				'exerpt' => 'Summary of Post One',
				'body' => 'Body of Post One',
				'image_path' => 'Empty',
				'min_to_read' => '2',

			],
			[
				'title' => 'Post Two',
				'exerpt' => 'Summary of Post Two',
				'body' => 'Body of Post Two',
				'image_path' => 'Empty',
				'min_to_read' => '2',

			]
		];
		foreach ($posts as $key => $value) {
			Post::create($value);
		}
	}
}
