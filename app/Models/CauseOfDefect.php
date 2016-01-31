<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CauseOfDefect extends Model
{
    protected $fillable = [
        'info_id',
        'cause_of_defect',
        'cause_of_defect_description',
        'objective_evidence'
    ];

    // DEFINE RELATIONSHIPS --------------------------------------------------
    public function info() {
        return $this->belongsTo('App\Models\Info');
    }
}
