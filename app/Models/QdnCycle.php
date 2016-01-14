<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QdnCycle extends Model
{

    protected $fillable = [
        'info_id',
        'cycle_time',
        'production_cycle_time',
        'process_engineering_cycle_time',
        'quality_assurance_cycle_time',
        'other_department_cycle_time'
    ];

    // DEFINE RELATIONSHIPS --------------------------------------------------
    public function info() {
        return $this->belongsTo('Info');
    }

}
