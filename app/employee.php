<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['user_id','name','department','position'];
    /**
     * Get the account record associated with the employee.
     */
    public function user()
    {
        return $this->hasOne('App\User','employee_id','user_id');
    }

    /**
     * questions use to reset password
     * @return [type] [description]
     */

    public function question()
    {
        return $this->hasOne('App\Question','user_id','user_id'); // this matches the Eloquent model
    }

    public function scopeFindBy($query, $column, $keyword)
    {
        return $query->where($column, $keyword);
    }
}
