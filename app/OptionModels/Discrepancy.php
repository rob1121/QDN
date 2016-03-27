<?php

namespace App\OptionModels;

use Illuminate\Database\Eloquent\Model;

class Discrepancy extends Model
{
    protected $table = 'discrepancies';
    protected $fillable = ['name','category','is_major'];
}
