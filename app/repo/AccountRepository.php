<?php
namespace App\repo;

use App\Employee;
use App\Question;
use App\User;
use Hash;

/**
 * Account Repository
 */
class AccountRepository implements AccountRepositoryInterface {

	/**
	 * @param $id
	 * @return mixed
     */
	public function findUser($id) {
		return User::whereEmployeeId($id)->first();
	}

    /**
     * @param $id
     * @return mixed
     */
    public function findEmployee($id) {
		return Employee::whereUserId($id)->first();
	}

    /**
     * @param $request
     * @return mixed
     */
    public function isAnswerCorrect($request) {
		$user = $this->findEmployee($request->id);
		return $user->question()->where('answer', $request->answer)->count();
	}

    /**
     * @param $id
     * @param $request
     */
    public function updateEmployee($id, $request) {
        $employee = collect(new Employee($request->all()))->toArray();
        
		Employee::whereUserId($id)->update($employee);
	}

    /**
     * @param $id
     * @param $request
     */
    public function updateUser($id, $request) {
		Question::whereUserId($id)->update(['question' => $request->question, 'answer' => $request->answer]);

		if ($request->password != '') {
			User::whereEmployeeId($id)->update(['password' => Hash::make($request->password),
			]);
		}
	}

}