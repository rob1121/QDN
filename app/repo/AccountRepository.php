<?php
namespace App\repo;

use App\Employee;
use App\User;
use Hash;
use Image;



class AccountRepository implements AccountRepositoryInterface {


	public function findUser($id)
    {
		return User::whereEmployeeId($id)->first();
	}


    public function findEmployee($id)
    {
		return Employee::whereUserId($id)->first();
	}


    public function isAnswerCorrect($request)
    {
		$user = $this->findEmployee($request->id);
		return $user->question()->where('answer', $request->answer)->count();
	}


    public function updateEmployee($employee, $request)
    {
        $array = collect(new Employee($request->all()))->toArray();
        
		$employee->update($array);
	}


    public function updateUser($employee, $request)
    {
        $employee->question()->update([
            'question' => $request->question,
            'answer' => $request->answer
        ]);

        $user = user();
        if ($request->hasFile('avatar'))
        {
            $avatar = $request->file('avatar');
            $filename = user()->id . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300,300)->save(public_path('/uploads/avatar/' . $filename));

            $user->avatar = $filename;
        }

		if ($request->password != '')
        {
            $user->password = Hash::make($request->password);
        }

        $user->save();
    }

}