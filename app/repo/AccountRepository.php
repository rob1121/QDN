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
	 * return user data
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function findUser($id) {
		return User::whereEmployeeId($id)->first();
	}

	/**
	 * return employee data
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function findEmployee($id) {
		return Employee::whereUserId($id)->first();
	}

	/**
	 * return boolean validation
	 * @param  [type]  $request [description]
	 * @return boolean          [description]
	 */
	public function isAnswerCorrect($request) {
		$user = $this->findEmployee($request->id);
		return $user->question()->where('answer', $request->answer)->count();
	}

	/**
	 * update employee table
	 * @param  [type] $id      [description]
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public function updateEmployee($id, $request) {
		Employee::whereUserId($id)->update([
			'name'       => $request->name,
			'position'   => $request->position,
			'department' => $request->department,
			'station'    => $request->station,
			'email'      => $request->email,
		]);
	}

	/**
	 * update user table
	 * @param  [type] $id      [description]
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public function updateUser($id, $request) {
		Question::whereUserId($id)->update(['question' => $request->question, 'answer' => $request->answer]);

		if ($request->password != '') {
			User::whereEmployeeId($id)->update(['password' => Hash::make($request->password),
			]);
		}
	}

}