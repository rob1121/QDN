<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvolvePerson extends Model
{
    protected $fillable = [
        'info_id',
        'department',
        'originator_id',
        'originator_name',
        'receiver_id',
        'receiver_name'
    ];

    // DEFINE RELATIONSHIPS --------------------------------------------------
    public function info() {
        return $this->belongsTo('App\Models\Info');
    }

}
