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
			$table->unsignedBigInteger('user_id');
			$table->string('title')->unique();
			$table->text('excerpt')->nullable(); // Can be null (DEFAULT NULL)
			$table->text('body');
			$table->integer('min_to_read')->default(1);
			$table->string('image_path')->nullable();
			$table->boolean('is_published')->default(false);
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
