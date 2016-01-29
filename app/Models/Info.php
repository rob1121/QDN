<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

use Carbon;
use DB;

class Info extends Model implements SluggableInterface
{
    public $dateTime;
    use SluggableTrait;

    protected $sluggable = [
        'build_from' => 'problem_description',
        'save_to'    => 'slug',
    ];

    protected $fillable = [
        'control_id',
        'customer',
        'package_type',
        'device_name',
        'lot_id_number',
        'lot_quantity',
        'job_order_number',
        'machine',
        'station',
        'date',
        'year',
        'month',
        'major',
        'disposition',
        'problem_description',
        'failure_mode',
        'discrepancy_category',
        'quantity',
    ];

    // DEFINE RELATIONSHIPS --------------------------------------------------
    public function causeOfDefect() {
        return $this->hasOne('App\Models\CauseOfDefect'); // this matches the Eloquent model
    }
    public function containmentAction() {
        return $this->hasOne('App\Models\ContainmentAction'); // this matches the Eloquent model
    }

    public function correctiveAction() {
        return $this->hasOne('App\Models\CorrectiveAction'); // this matches the Eloquent model
    }

    public function preventiveAction() {
        return $this->hasOne('App\Models\PreventiveAction'); // this matches the Eloquent model
    }

    public function qdnCycle() {
        return $this->hasOne('App\Models\Qdncycle'); // this matches the Eloquent model
    }

    public function closure() {
        return $this->hasOne('App\Models\Closure'); // this matches the Eloquent model
    }

    public function involvePerson() {
        return $this->hasMany('App\Models\InvolvePerson');
    }


    //model mutators-----------------------------------------------------------
    /**
     * set control number fomart before save
     */
   public function setControlIdAttribute($value) {
        $today = Carbon::now('Asia/Manila');
        $year  = $today->format('y');
        $this->attributes['control_id'] = $year . "-" . sprintf("%'.04d", $value);
    }

    /**
     * retrieving data from table for BMP graphs
     */
    public function scopePod($query, $month, $year, $select = 'all')
    {
        if ($select == '' || $select == 'all') {

            return $query->select(DB::raw(
                    'COUNT(discrepancy_category) as paretoFirst,
                    discrepancy_category as category'
                ))
                ->groupBy('discrepancy_category')
                ->where(DB::raw('MONTH(created_at)'), $month)
                ->where(DB::raw('YEAR(created_at)'), $year)
                ->get();

        }

        if ($select == 'failureMode') {

            return $query->select(DB::raw(
                    'COUNT(failure_mode) as paretoFirst,
                    failure_mode as category'
                ))
                ->groupBy('failure_mode')
                ->where(DB::raw('MONTH(created_at)'), $month)
                ->where(DB::raw('YEAR(created_at)'), $year)
                ->get();

        }

        return $query->select(DB::raw(
                'COUNT(failure_mode) as paretoFirst,
                failure_mode as category'
            ))
            ->groupBy('failure_mode')
            ->where(DB::raw('MONTH(created_at)'), $month)
            ->where(DB::raw('YEAR(created_at)'), $year)
            ->where('failure_mode', $select)
            ->get();

    }

    /**
     * get qdndata for year round
     */
    public function scopeQdn($query, $year)
    {
        $query->select(
                DB::raw('
                    MONTH(created_at) as month,
                    COUNT(MONTH(created_at)) as count
                ')
            )
            ->where(DB::raw('YEAR(created_at)'), $year)
            ->groupBy('month');
    }

}
