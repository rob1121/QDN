<?php

namespace App\Http\Controllers;

use App\Events\EmailQdnNotificationEvent;
use App\Http\Controllers\report\CrudController;
use App\Http\Requests\QdnCreateRequest;
use App\Models\Info;
use Event;
use Flash;
use Illuminate\Http\Request;
use JavaScript;
use PDF;

class reportController extends CrudController {

	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * controller for qdn issuance form
	 * @return [type] [description]
	 */
	public function report() {
		return view('report.create');
	}

	/**
	 * store data to the qdn database
	 * @param  QdnCreateRequest $request [validation]
	 * @return [type]                    [description]
	 */
	public function store(QdnCreateRequest $request) {
		Flash::warning('Oh Snap!! This QDN is already registered. In doubt? ask QA to assist you!');
		if (Info::isExist($request)->count() == 0) {
			$this->add($request);
			//send email notification
			Event::fire(new EmailQdnNotificationEvent());
			Flash::success('Success! Team responsible will be notified regarding the issue via email!');
		}

		return redirect('/');
	}

	/**
	 * view controller for issued QDN
	 * @param  [type] $slug [description]
	 * @return [type]       [description]
	 */
	public function show(Info $slug) {
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

		return view('report.view', compact('qdn', 'department'));
	}

	/**
	 * update tables and redirect to home
	 * @param  [type]  $slug    [description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function draft(Info $slug, Request $request) {
		$this->save($slug, $request);
		Flash::success('Successfully save! Issued QDN are save as draft and still subject for completion!');
		return redirect('/');
	}

	/**
	 * update tables, send email and redirect to home
	 * @param  [type]  $slug    [description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function forApproval(Info $slug, Request $request) {
		$this->save($slug, $request);
		$slug->closure()->update(['status' => 'incomplete approval']);
		// send email
		Flash::success('Successfully save! Issued QDN is now subject for Approval!');
		return redirect('/');
	}

	/**
	 * for printing qdn form
	 * @param  [type] $slug [description]
	 * @return [type]       [description]
	 */

	public function pdf(Info $slug) {
		$qdn        = $slug;
		$department = $this->getDepartment($qdn);
		return PDF::loadHTML(view('pdf.print', compact('qdn', 'department')))->stream();
		// return file_get_contents('/');
	}

	/**
	 * function for approval form
	 * @param  [type] $slug [description]
	 * @return [type]       [description]
	 */
	public function approval(Info $slug) {
		$qdn          = $slug;
		$department   = $this->getDepartment($qdn);
		$linkDraft    = route('draft_link', ['slug' => $slug->slug]);
		$linkApproval = route('approval_link', ['slug' => $slug->slug]);

		JavaScript::put('linkDraft', $linkDraft);
		JavaScript::put('linkApproval', $linkApproval);
		JavaScript::put('category', $qdn->major);
		JavaScript::put('discrepancy_category', $qdn->discrepancy_category);
		JavaScript::put('qdn', $qdn);
		return view('report.approval.view', compact('qdn', 'department'));
	}

	/**
	 * get unique department
	 * @param  [type] $qdn [description]
	 * @return [type]      [description]
	 */
	public function getDepartment($qdn) {
		return array_unique(array_flatten($qdn->involvePerson()
				->select('department')
				->get()
				->toArray()));
	}
}
