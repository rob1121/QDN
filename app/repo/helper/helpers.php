<?php
use Illuminate\Support\Facades\Auth;

/**
 * Created by PhpStorm.
 * User: tspi.qa
 * Date: 6/2/2016
 * Time: 9:06 AM
 * @param $qdn
 * @return string
 */
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
        ? array_search(user()->employee->station, $unique)
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
    switch ($user->employee->department) {
        case 'quality_assurance':
            $userClosure = $closure->quality_assurance;
            break;

        case 'process_engineering':
            $userClosure = $closure->process_engineering;
            break;

        case 'production':
            $userClosure = $closure->production;
            break;

        case 'other_department':
            $userClosure = $closure->other_department;
            break;
    }
    return $userClosure;
}