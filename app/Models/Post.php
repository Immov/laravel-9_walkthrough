<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model {
	protected $fillable = [
		'user_id', 'title', 'excerpt', 'body', 'image_path', 'is_published', 'min_to_read'
	]; // prevents unwanted insertion of unintendent values
	use HasFactory;

	public function user() {
		return $this->belongsTo(User::class);
	}

	public function meta() {
		return $this->hasOne(PostMeta::class);
	}

	public function categories() {
		return $this->belongsToMany(Category::class);
	}
}
