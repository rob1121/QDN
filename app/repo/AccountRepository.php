<?php
namespace App\repo;

use App\Employee;
use App\repo\Account\UserInterface;
use App\User;
use Illuminate\Foundation\Validation\ValidatesRequests;


class AccountRepository implements AccountRepositoryInterface {
    use ValidatesRequests;
    protected $request;
    public $user;

    public function validateRequest($request, $user) {
        $this->validate($request, User::rules);

        $this->request = $request;
        $this->user = $user;
    }

	public function findUser($id) {
		return User::whereEmployeeId($id)->first();
	}


    public function findEmployee($id) {
		return Employee::whereUserId($id)->first();
	}


    public function isAnswerCorrect($request) {
		$user = $this->findEmployee($request->id);
		return $user->question()->where('answer', $request->answer)->count();
	}
    
    public function update(UserInterface $user)
    {
        $user->update();
    }
}