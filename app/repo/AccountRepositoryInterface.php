<?php
namespace App\repo;

interface AccountRepositoryInterface {

	public function findUser($id);

	public function findEmployee($id);

	public function isAnswerCorrect($request);

}