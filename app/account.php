<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = ['employee_id','password','status','access_level'];
    /**
     * Get the employee that owns the account.
     */
    public function employee()
    {
        return $this->belongsTo('Employee','employee_id','user_id');
    }
}
