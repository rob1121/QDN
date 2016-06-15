<?php
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

function check($qdn, $value)
{
    return $value == $qdn->major 
        ? '[&nbsp;x&nbsp;]' 
        : '[&nbsp;&nbsp;&nbsp;&nbsp;]';
}

/**
 * @param $qdn
 * @return bool
 */
function validate($qdn)
{
    $stations = array_pluck($qdn->involvePerson, 'station');

    return in_array(user()->employee->station, $stations) && $qdn->closure->status == 'Incomplete Fill-Up';
}

/**
 * @param $qdn
 * @return string
 */
function isHidden($qdn)
{
    return validate($qdn) ? '':'hidden';
}

/**
 * @param $qdn
 * @return string
 */
function isDisabled($qdn)
{
    return validate($qdn) ? '':'disabled';
}

function user()
{
    return Auth::user()->load('employee');
}

/**
 * @param $qdn
 * @return bool
 */
function isIncompleteFillUpRespondent($qdn)
{
    $unique = $qdn->involvePerson->unique('station');

    if ($unique->count() == 0) return false;

    $array_search = $unique->count() > 1
        ? array_search(user()->employee->station, $unique->toArray())
        : user()->employee->station == $unique[0]->station;

    return $qdn->closure->status == 'Incomplete Fill-Up'
        && $array_search;
}
/**
 * @param $qdn
 * @return string
 */
function uniqueStation($qdn)
{
    $station = '';
    foreach ($qdn->involvePerson->unique('station') as $employee)
        $station .= "{$employee->station} <br/>";
    
    return $station;
}

/**
 * @param $user
 * @param $qdn
 * @return bool
 */
function isApprover($user, $qdn)
{
    return in_array($user->access_level, ['admin', 'signatory'])
        && hasEmptyClosure($qdn->closure)
        && ('' == userClosure($user, $qdn->closure) || hasNoOtherDepartmentInvolve($user->employee, $qdn))
        && ! hasApproved($user->employee, $qdn);
}

/**
 * @param $user
 * @param $qdn
 * @return bool
 */
function hasApproved($user, $qdn)
{
    return ($user->name == $qdn->closure->production)
        || ($user->name == $qdn->closure->process_engineering)
        || ($user->name == $qdn->closure->quality_assurance)
        || ($user->name == $qdn->closure->other_department);
}

/**
 * @param $user
 * @param $qdn
 * @return bool
 */
function hasNoOtherDepartmentInvolve($user, $qdn)
{
    $departments = array_pluck($qdn->involvePerson, 'department');

    return ! in_array('other_department', $departments) && $user->department == 'quality_assurance'
        ? true
        : false;
}

/**
 * @param $closure
 * @return bool
 */
function hasEmptyClosure($closure)
{
    return ('' == $closure->production)
            || ('' == $closure->process_engineering)
            || ('' == $closure->quality_assurance)
            || ('' == $closure->other_department);
}

/**
 * @param $user
 * @param $closure
 * @return mixed
 */
function userClosure($user, $closure)
{
    $preference = collect([
        'quality_assurance' => $closure->quality_assurance,
        'process_engineering' => $closure->process_engineering,
        'production' => $closure->production,
        'other_department' => $closure->other_department,
    ])->get($user->employee->department);

    return $preference;
}

function oe_link($qdn, $oe)
{
    $year = Carbon::parse($qdn->created_at)->year;
    $timestamp = strtotime($qdn->created_at);

    return "/objective_evidence/{$year}/{$qdn->control_id}/{$oe}?date={$timestamp}";
}

function toObject($array)
{
    return json_decode(json_encode($array));
}

function diffForHumans($date)
{
    return Carbon::parse($date)->diffForHumans();
}