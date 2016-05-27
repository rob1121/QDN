<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['user_id','question','answer'];

    public function info() {
        return $this->belongsTo('App\Employee');
    }
}
