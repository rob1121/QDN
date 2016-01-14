<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;

use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ResetQuestionRequest;
use App\Http\Requests\NewPasswordRequest;
use App\Http\Controllers\Controller;
use App\Employee;
use Flash;
use Hash;
class AccountPasswordController extends Controller
{
            /**
             * index of reset form
             * @return [type] [description]
             */
            public function index(){
                return view('reset.reset');
            }

            /**
             * get employee details
             * @param  ResetPasswordRequest $request [description]
             * @return [type]                        [description]
             */
            public function postIndex(ResetPasswordRequest $request){
                $id = $request->employee_id;
                return redirect('/account/question/'.$id);
            //...
            }

            /**
             * display sercret question
             * @param  [type] $id [description]
             * @return [type]     [description]
             */
            public function question($id){
                $user = Employee::findBy('user_id',$id)->first();
                return view('reset.question', compact(['user']));
            //...
            }

            /**
             * validate answer
             * @param  ResetQuestionRequest $request [description]
             * @return [type]                        [description]
             */
            public function postQuestion(ResetQuestionRequest $request){
                $id = $request->id;
                $employee = Employee::findBy('user_id',$id)->first();

                $verifyAnswer = $employee->question()
                ->where('answer',$request->answer)
                ->count();

                if ($verifyAnswer == 0) {
                    Flash::error('Wrong answer, please try again');
                    return redirect('/account/question/'.$id);
                }

                return redirect('/account/new-password/'.$id);
            }

            /**
             * enter new password
             * @param  [type] $id [description]
             * @return [type]     [description]
             */
            public function reset($id){
                $user = Employee::findBy('user_id',$id)->first();
                return view('reset.new', compact(['user']));
            //...
            }

            /**
             * save and login to the system
             * @param  NewPasswordRequest $request [description]
             * @return [type]                      [description]
             */
            public function postReset(NewPasswordRequest $request){
                $user = Employee::findBy('user_id',$request->id)->first();
                $user->user()
                    ->update(['password' => Hash::make($request->password)]);
                return redirect('login');
            //...
            }
}
