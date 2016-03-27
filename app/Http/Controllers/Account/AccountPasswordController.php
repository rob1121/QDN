<?php

namespace App\Http\Controllers\Account;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ResetQuestionRequest;
use App\repo\AccountRepository;
use App\User;
use Flash;
use Illuminate\Http\Request;

class AccountPasswordController extends Controller {
	public $user;

	public function __construct(AccountRepository $user) {
		$this->middleware('auth', ['only' => ['profile', 'UpdateProfile']]);
		$this->user = $user;
	}
	/**
	 * index of reset form
	 * @return [type] [description]
	 */
	public function index() {
		return view('reset.reset');
	}

	/**
	 * get employee details
	 * @param  ResetPasswordRequest $request [description]
	 * @return [type]                        [description]
	 */
	public function postIndex(ResetPasswordRequest $request) {
		return redirect('/account/question/' . $request->employee_id);
		//...
	}

	/**
	 * display sercret question
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function question($id) {
		$user = $this->user->findEmployee($id);
		return view('reset.question', compact(['user']));
		//...
	}

	/**
	 * validate answer
	 * @param  ResetQuestionRequest $request [description]
	 * @return [type]                        [description]
	 */
	public function postQuestion(ResetQuestionRequest $request) {
		if ($this->user->isAnswerCorrect($request)) {
			return redirect('/account/new-password/' . $request->id);
		}
		Flash::error('Wrong answer, please try again');
		return redirect('/account/question/' . $request->id);
	}

	/**
	 * enter new password
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function reset($id) {
		$user = $this->user->findEmployee($id);
		return view('reset.new', compact(['user']));
		//...
	}

	/**
	 * save and login to the system
	 * @param  NewPasswordRequest $request [description]
	 * @return [type]                      [description]
	 */
	public function postReset(NewPasswordRequest $request) {
		$user = $this->user->findEmployee($request->id);
		$user->user()->update(['password' => $request->password]);
		Flash::success('Account password successfully reset! ');
		return redirect(route('welcome'));
		//...
	}

	public function profile($id) {
		$user = $this->user->findUser($id);
		return view('account.profile', compact('user'));
	}

	/**
	 * update profile
	 * @param [type]  $id      [description]
	 * @param Request $request [description]
	 */
	public function UpdateProfile($id, Request $request) {
		$this->user->updateEmployee($id, $request);
		$this->user->updateUser($id, $request);
	}
}
