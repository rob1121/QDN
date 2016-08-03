<?php namespace App\Http\Controllers\Account;

use App\Employee;
use App\repo\Account\UserAccount;
use App\repo\Account\UserEmployee;
use App\repo\Account\UserSecretQuestion;
use App\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ResetQuestionRequest;
use App\repo\AccountRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laracasts\Flash\Flash;

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
		return view('reset.question', ['user' => $this->user->findEmployee($id)]);
		//...
	}

	public function postQuestion(ResetQuestionRequest $request) {
		if ($this->user->isAnswerCorrect($request))
			return redirect('/account/new-password/' . $request->id);

		Flash::error('Wrong answer, please try again');
		return redirect('/account/question/' . $request->id);
	}

	public function reset($id) {
		return view('reset.new', ['user' => $this->user->findEmployee($id)]);
		//...
	}

	public function postReset(NewPasswordRequest $request) {
		$user = $this->user->findEmployee($request->id);
		$user->user()->update(['password' => Hash::make($request->password)]);
		Flash::success('Account password successfully reset! ');
		return redirect(route('welcome'));
	}

	public function profile(User $id) {
		return view('account.profile', $this->getProfileVaraibles($id));
	}

		protected function getProfileVaraibles($id) {
			return [
				'user' => $id,
				 'route_UpdateProfile' => route('UpdateProfile', ['id' => user()->employee_id])
			];
		}

	public function UpdateProfile(Employee $id, Request $request) {
		$this->user->validateRequest($request, $id);
		$this->user->update(new UserEmployee($request, $id));
		$this->user->update(new UserSecretQuestion($request, $id));
		$this->user->update(new UserAccount($request, $id));

		Flash::success('Account successfully updated');
        return redirect()->back();
	}
}