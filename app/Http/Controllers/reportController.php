<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\QdnCreateRequest;
use App\Http\Controllers\Controller;

use App\OptionModels\Option;
use App\OptionModels\Machine;
use App\OptionModels\Station;

use App\Employee;

use App\Models\Info;
use App\Models\CorrectiveAction;
use App\Models\ContainmentAction;
use App\Models\PreventiveAction;
use App\Models\InvolvePerson;
use App\Models\Closure;
use App\Models\QdnCycle;

use Str;
use Carbon;
use Auth;
use Flash;

class reportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * controller for qdn issuance form
     * @return [type] [description]
     */
    public function report()
    {
        // failure mode list
        return view('report.create');
    }

    /**
     * store data to the qdn database
     * @param  QdnCreateRequest $request [validation]
     * @return [type]                    [description]
     */
    public function store(QdnCreateRequest $request)
    {
        $currentUser = Auth::user();
        $currentYear = Carbon::now('Asia/Manila')->format('y');

        $lastIn      = Info::orderBy('id', 'desc')->first();
        $lastInYear  = substr($lastIn->control_id, 0, 2);
        $lastInId    = substr($lastIn->control_id, 3);

        //control_id
        $control_id = $currentYear == $lastInYear
            ? $lastInId + 1
            : 1;

        //customer
        $customer = $request->customer == "not yet specified"
            ? $request->customerField
            : $request->customer;

        $info = Info::create([
            'control_id'           => $control_id,
            'customer'             => $customer,
            'package_type'         => $request->package_type,
            'device_name'          => $request->device_name,
            'lot_id_number'        => $request->lot_id_number,
            'lot_quantity'         => $request->lot_quantity,
            'job_order_number'     => $request->job_order_number,
            'machine'              => $request->machine,
            'station'              => $request->station,
            'major'                => $request->major,
            'disposition'          => '',
            'problem_description'  => $request->problem_description,
            'failure_mode'         => $request->failure_mode,
            'discrepancy_category' => $request->discrepancy_category,
            'quantity'             => $request->quantity
        ]);

        CauseOfDefect::create([
            'info_id'                     => $info->id,
            'cause_of_defect'             => '',
            'cause_of_defect_description' => '',
            'objective_evidence'          => ''
        ]);

        CorrectiveAction::create([
            'info_id'            => $info->id,
            'what'               => '',
            'who'                => '',
            'objective_evidence' => ''
        ]);

        ContainmentAction::create([
            'info_id'            => $info->id,
            'what'               => '',
            'who'                => '',
            'objective_evidence' => ''
        ]);

        PreventiveAction::create([
            'info_id'            => $info->id,
            'what'               => '',
            'who'                => '',
            'objective_evidence' => ''
        ]);

        foreach ($request->receiver_name as $name) {
           $person = Employee::findBy('name',$name)->first();

            InvolvePerson::create([
                'info_id'         => $info->id,
                'department'      => $person->department,
                'originator_id'   => $currentUser->employee_id,
                'originator_name' => $currentUser->employee->name,
                'receiver_id'     => $person->user_id,
                'receiver_name'   => $person->name
            ]);
        }

        Closure::create([
            'info_id'                  => $info->id,
            'containment_action_taken' => '',
            'corrective_action_taken'  => '',
            'close_by'                 => '',
            'date_sign'                => '',
            'production'               => '',
            'process_engineering'      => '',
            'quality_assurance'        => '',
            'other_department'         => '',
            'status'                   => 'for pe review'
        ]);

        QdnCycle::create([
            'info_id'                        => $info->id,
            'cycle_time'                     => '',
            'production_cycle_time'          => '',
            'process_engineering_cycle_time' => '',
            'quality_assurance_cycle_time'   => '',
            'other_department_cycle_time'    => ''
        ]);

        Flash::success('Success! Team responsible will be notified regarding the issue via email!');
        return redirect('/');
    }

    /**
     * view controller for issued QDN
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function show($slug)
    {
        $qdn = Info::findBySlug($slug)->first();
        return view('report.view', compact('qdn'));
    }
}
