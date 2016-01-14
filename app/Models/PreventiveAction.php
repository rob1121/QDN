<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreventiveAction extends Model
{

    protected $fillable = [
            'info_id',
            'what',
            'who',
            'objective_evidence'
    ];

    // DEFINE RELATIONSHIPS --------------------------------------------------
    public function info() {
        return $this->belongsTo('Info');
    }

}
