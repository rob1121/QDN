<?php

namespace App\repo\Option;
use App\Employee;
use App\OptionModels\Station;
use App\User;
use JavaScript;
use Validator;

class EmployeeRepo {
    /**
     * @return mixed
     */
    public function all()
    {
        return Employee::with('user')->orderBy('user_id')->get();
    }

    /**
     * @param $name
     * @return mixed
     */
    public function get($name)
    {
        return Employee::whereName($name)->first();
    }

    /**
     * @return mixed
     */
    public function setup()
    {
        $employees = $this->all();
        $this->links($employees);

        return $employees;
    }

    /**
     * @param $set
     * @return array
     */
    public function rules($set)
    {
        $rules =  [
            'name'         => 'required',
            'access_level' => 'required',
            'station'      => 'required',
            'position'     => 'required',
        ];

        if ($set == 'new')
        {
            $rules['user_id'] = 'required | numeric | unique:employees,user_id';
            $rules['password'] = 'required';
        }
        return $rules;
    }

    /**
     * @param $request
     * @param string $set
     * @return mixed
     */
    public function validate($request, $set = 'new')
    {
        return Validator::make($request->all(), $this->rules($set));
    }

    /**
     * @param $query
     */
    public function links($query)
    {
        JavaScript::put('employees', $query);
        JavaScript::put('links', [
            'newEmployee' => route('newEmployeesOptions'),
            'updateEmployee' => route('updateEmployeesOptions'),
            'removeEmployee' => route('removeEmployeesOptions'),
        ]);
    }

    /**
     * @param $request
     * @return $this
     */
    public function stores($request)
    {
        $validation = $this->validate($request);
        if ($validation->fails())
        {
            return $validation->errors();
        }

        return $this->storeEmployee($request)->load('user');
    }

    /**
     * @param $request
     * @return mixed
     */
    public function updates($request)
    {
        $validation = $this->validate($request, 'update');
        if ($validation->fails())
        {
            return $validation->errors();
        }

        return $this->updateEmployee($request);
    }

    /**
     * @param $request
     * @return static
     */
    public function storeEmployee($request)
    {
        $employee = Employee::create($request->all());
        $employee->update([
            'status'     => 'active',
            'department' => Station::where('station', $request->station)->first()->department,
        ]);

        $employee->user()->save(new user($request->all() ));

        return $employee;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function updateEmployee($request)
    {
        $user = collect(new User($request->all()))->toArray();

        $employee = Employee::whereUserId($request->user_id)->first();
        $employee->update($request->all());
        $employee->user()->update($user);

        return $employee->load('user');
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        Employee::whereId($id)->delete();
    }

}