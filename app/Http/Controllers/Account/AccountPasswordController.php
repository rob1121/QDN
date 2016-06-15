<?php namespace App\Http\Controllers\Account;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ResetQuestionRequest;
use App\repo\AccountRepository; 
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountPasswordController extends Controller {
	public $user;

	public function __construct(AccountRepository $user) {
		$this->middleware('auth', ['only' => ['profile', 'UpdateProfile']]);
		$this->user = $user;
	}


	public function index() {
		return view('reset.reset');
	}

	public function postIndex(ResetPasswordRequest $request) {
		return redirect('/account/question/' . $request->employee_id);
		//...
	}

	public function question($id) {
		$user = $this->user->findEmployee($id);
		return view('reset.question', compact(['user']));
		//...
	}

	public function postQuestion(ResetQuestionRequest $request) {
		if ($this->user->isAnswerCorrect($request)) {
			return redirect('/account/new-password/' . $request->id);
		}
		Flash::error('Wrong answer, please try again');
		return redirect('/account/question/' . $request->id);
	}

	public function reset($id) {
		$user = $this->user->findEmployee($id);
		return view('reset.new', compact(['user']));
		//...
	}

	public function postReset(NewPasswordRequest $request) {
		$user = $this->user->findEmployee($request->id);
		$user->user()->update(['password' => Hash::make($request->password)]);
		Flash::success('Account password successfully reset! ');
		return redirect(route('welcome'));
		//...
	}

	public function profile($id) {
		$user = $this->user->findUser($id);
		return view('account.profile', compact('user'));
	}

	public function UpdateProfile(Employee $id, Request $request) {
		$this->user->updateEmployee($id, $request);
		$this->user->updateUser($id, $request);

		Flash::success('Account successfully updated');
        return redirect()->back();
	}
}