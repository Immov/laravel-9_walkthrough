<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('posts', function (Blueprint $table) {
			$table->id(); // Set as primary Key $table->id()->primary();
			$table->string('title')->unique();
			$table->text('exerpt')->nullable(); // Can be null (DEFAULT NULL)
			$table->text('body');
			$table->integer('min_to_read')->default(1);
			$table->string('image_path')->nullable();
			$table->boolean('is_published')->default(false);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('posts');
	}
};
