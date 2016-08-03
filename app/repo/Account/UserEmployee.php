<?php namespace App\repo\Account;


use App\Employee;

class UserEmployee implements UserInterface
{

    protected $request;
    protected $user;

    public function __construct($request, $user)
    {
        $this->request = $request;
        $this->user = $user;
    }

    public function update()
    {
        $array = collect(new Employee($this->request->all()))->toArray();
        $this->user->update($array);
        
    }
}