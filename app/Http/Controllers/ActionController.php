<?php

namespace App\Http\Controllers;

use App\Models\Info;
use App\repo\InfoRepository;
use Flash;
use Illuminate\Http\Request;

class ActionController extends Controller {
	protected $qdn;

	/**
	 * authentication protected
	 */
	public function __construct(InfoRepository $qdn) {
		$this->middleware('auth');
		$this->qdn = $qdn;
	}
//========================================== PE VERIFICATION =====================================
	/**
	 * method in section one that will save the status if pe decided to validate qdn
	 * @param Request $request [description]
	 * @param Info    $slug    [description]
	 */
	public function SectionOneSaveAndProceed(Request $request, Info $slug) {
		//send mail
		// Event::fire(new EmailQdnNotificationEvent());
		$this->qdn->SectionOneUpdate($request, $slug);
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
		$collection = $this->qdn->SectionOneUpdate($request, $slug);
		return array_add($request->all(), 'department', $collection['emp_dept']);
	}
//=========================== FOR QDN COMPLETION =================================================
	/**
	 * this method is for completing the ca, cn, pa table
	 * @param Info $slug [description]
	 */
	public function ForIncompleteFillUp(Info $slug) {
		return $this->qdn->view($slug, 'report.incomplete');
	}

	/**
	 * update tables and redirect to home
	 * @param  [type]  $slug    [description]
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function draft(Info $slug, Request $request) {
		$this->qdn->save($slug, $request);
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
		$this->qdn->save($slug, $request);
		$slug->closure()->update(['status' => 'incomplete approval']);
		// send email
		Flash::success('Successfully save! Issued QDN is now subject for Approval!');
		return redirect('/');
	}
//===================================== FOR QDN APPROVALS =========================================
	/**
	 * function for approval form
	 * @param  [type] $slug [description]
	 * @return [type]       [description]
	 */
	public function approval(Info $slug) {
		return $this->qdn->view($slug, 'report.approval.view');
	}

	/**
	 * approval post method that update cycletime and closure table
	 * @param Info $slug [description]
	 */
	public function UpdateForApprroval(Info $slug) {
		//update closure and qdncycle table
		//fire event log
		//fire email notif event
		//flash success alert message
		//return home page
	}

//================================= FOR QA VERIFICATION ==================================================
	/**
	 * view of qdn that are for closure
	 * @param Info $slug [description]
	 */
	public function QaVerification(Info $slug) {
		// view qdn
	}

	public function QaVerificationUpdate(Info $slug, Request $request) {
		// update qdn closures
		// send email notification
		// add flash alert notification
		// view home page
	}

}
