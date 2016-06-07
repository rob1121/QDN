<?php namespace App\repo\Traits;


use Carbon\Carbon;

trait DateTime
{
    public $setMonth;
    public $setYear;
    
    public function __construct()
    {
     $this->setMonth = $this->month();
    }

    /**
     * @return mixed
     */
    public function date()
    {
        return Carbon::now('Asia/Manila');
    }

    /**
     * @return mixed
     */
    public function month()
    {
        return null == $this->setMonth ? $this->date()->format('m') : $this->setMonth;
    }

    /**
     * @return mixed
     */
    public function year()
    {
        return null == $this->setYear ? $this->date()->format('Y') : $this->setYear;
    }

    /**
     * @return string
     */
    public function yearNow()
    {
        return Carbon::now('Asia/Manila')->format('y');   
    }
}