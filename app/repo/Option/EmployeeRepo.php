<?php

namespace App\repo\Option;
use App\Employee;
use App\OptionModels\Station;
use App\User;
use JavaScript;
use Validator;

class EmployeeRepo {
    public function all() {
        return Employee::orderBy('user_id')->get()->load('user');
    }

    public function get($name) {
        return Employee::whereName($name)->first();
    }

    public function setup() {
        $employees = $this->all();
        $this->links($employees);
        return $employees;
    }

    public function rules($set) {
        $rules =  [
            'name'         => 'required',
            'access_level' => 'required',
            'station'      => 'required',
            'position'     => 'required',
        ];

        if ($set == 'new') {
            $rules['user_id'] = 'required | numeric | unique:employees,user_id';
            $rules['password'] = 'required';
        }
        return $rules;
    }

    public function validate($request, $set = 'new') {
        return Validator::make($request->all(), $this->rules($set));
    }

    public function links($query) {
        JavaScript::put('employees', $query);
        JavaScript::put('links', [
            'newEmployee' => route('newEmployeesOptions'),
            'updateEmployee' => route('updateEmployeesOptions'),
            'removeEmployee' => route('removeEmployeesOptions'),
        ]);
    }

    public function stores($request) {
        $validation = $this->validate($request);
        if ($validation->fails()) {
            return $validation->errors();
        }

        $this->storeUser($request);
        return $this->storeEmployee($request)->load('user');
    }

    public function updates($request) {
        $validation = $this->validate($request, 'update');
        if ($validation->fails()) {
            return $validation->errors();
        }

        $this->updateUser($request);
        return $this->updateEmployee($request);
    }

    public function storeEmployee($request) {
        $employee = Employee::create($request->all());
        $employee->update([
            'status'     => 'active',
            'department' => Station::whereStation($request->station)->first()->department,
        ]);
        return $employee;
    }

    public function storeUser($request) {
        User::create($request->all());
    }

    public function updateEmployee($request) {
        $employee = Employee::whereUserId($request->user_id)->first();
        $employee->update($request->all());
        return $employee->load('user');
    }

    public function updateUser($request) {
        User::whereEmployeeId($request->user_id)
        ->update(['access_level' => $request->access_level]);
    }

    /**
     * delete employee
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete($id) {
        Employee::whereId($id)->delete();
    }

}