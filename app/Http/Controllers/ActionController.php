<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Models\Info;
use App\Models\InvolvePerson;
use Illuminate\Http\Request;
use JavaScript;
use Laracasts\Flash\Flash as Flash;

class ActionController extends Controller {

	/**
	 * authentication protected
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * method to update data in section one
	 * @param [type] $request [description]
	 * @param [type] $slug    [description]
	 */
	public function SectionOneUpdate($request, $slug) {
		$slug->update($request->all());
		$arr_names     = [];
		$involvePerson = $slug->involvePerson()->first();
		$emp_dept      = [];
		foreach (array_unique($request->receiver_name) as $name) {
			$emp         = Employee::whereName($name)->first();
			$emp_dept[]  = $emp->station;
			$arr_names[] = new InvolvePerson([
				'department'      => $emp->station,
				'originator_id'   => $involvePerson->originator_id,
				'originator_name' => $involvePerson->originator_name,
				'receiver_id'     => $emp->user_id,
				'receiver_name'   => $name]);
		}

		$slug->involvePerson()->delete();
		$slug->involvePerson()->saveMany($arr_names);
		$collection = ['emp_dept' => $emp_dept, 'slug' => $slug];
		return $collection;
	}

	/**
	 * method in section one that will save the status if pe decided to validate qdn
	 * @param Request $request [description]
	 * @param Info    $slug    [description]
	 */
	public function SectionOneSaveAndProceed(Request $request, Info $slug) {
		//send mail
		// Event::fire(new EmailQdnNotificationEvent());
		$this->SectionOneUpdate($request, $slug);
		$slug->closure()->update(['status' => $request->status]);

		Flash::success('Successfully Verified !! QDN are now ready for completion!');
		return redirect('/');

	}

	/**
	 * Save section one as drop if pe are not yet decided
	 * @param Request $request [description]
	 * @param Info    $slug    [description]
	 */
	public function SectionOneSaveAsDraft(Request $request, Info $slug) {
		$collection = $this->SectionOneUpdate($request, $slug);
		return array_add($request->all(), 'department', $collection['emp_dept']);
	}

	/**
	 * this method is for completing the ca, cn, pa table
	 * @param Info $slug [description]
	 */
	public function ForIncompleteFillUp(Info $slug) {
		$qdn        = $slug;
		$department = $qdn->involvePerson()
			->select('department')
			->get()
			->toArray();

		$department   = array_unique(array_flatten($department));
		$linkDraft    = route('draft_link', ['slug' => $qdn->slug]);
		$linkApproval = route('approval_link', ['slug' => $qdn->slug]);

		JavaScript::put('linkDraft', $linkDraft);
		JavaScript::put('linkApproval', $linkApproval);
		JavaScript::put('category', $qdn->major);
		JavaScript::put('discrepancy_category', $qdn->discrepancy_category);
		JavaScript::put('qdn', $qdn);

		$department = array_unique(array_flatten($department));
		return view('report.incomplete', compact('qdn', 'department'));
	}

}
