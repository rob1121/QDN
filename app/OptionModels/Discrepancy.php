<?php

namespace App\OptionModels;

use Illuminate\Database\Eloquent\Model;
use Str;

class Discrepancy extends Model {
	protected $table    = 'discrepancies';
	protected $fillable = ['name', 'category', 'is_major'];
	public $timestamps  = false;

	public static function option()
	{
		return static::all()->pluck('category');
	}

	public function setCategoryAttribute($value) {
		return $this->attributes['category'] = strtolower($value);
	}
	public function getCategoryAttribute($value) {
		return $value ? Str::upper($value) : '-';
	}

}
