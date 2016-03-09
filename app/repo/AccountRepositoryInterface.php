<?php
namespace App\repo;

interface AccountRepositoryInterface {
	/**
	 * return user data
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function findUser($id);

	/**
	 * return employee data
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function findEmployee($id);

	/**
	 * return boolean validation
	 * @param  [type]  $request [description]
	 * @return boolean          [description]
	 */
	public function isAnswerCorrect($request);

	/**
	 * update employee table
	 * @param  [type] $id      [description]
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public function updateEmployee($id, $request);

	/**
	 * update user table
	 * @param  [type] $id      [description]
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public function updateUser($id, $request);

}