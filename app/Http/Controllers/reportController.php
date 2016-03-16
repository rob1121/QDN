<?php

namespace App\Http\Controllers;

use App\Events\ApprovalNotificationEvent;
use App\Events\EmailQdnNotificationEvent;
use App\Events\EventLogs;
use App\Http\Requests\QdnCreateRequest;
use App\Models\closure;
use App\Models\Info;
use App\repo\InfoRepository;
use Auth;
use Event;
use Flash;
use Illuminate\Http\Request;
use PDF;

class reportController extends Controller {
	protected $qdn;

	/**
	 * QDN Info Dependency Injection
	 * @param InfoRepository $qdn [description]
	 */
	public function __construct(InfoRepository $qdn) {

		$this->middleware('auth');
		$this->qdn       = $qdn;
		$this->qdn->user = Auth::user();
	}

	/**
	 * for printing qdn form
	 * @param  [type] $slug [description]
	 * @return [type]       [description]
	 */
	public function pdf(Info $slug) {
		Event::fire(new EventLogs($this->qdn->user, 'download' . $slug->control_id));
		$qdn = $slug;
		return PDF::loadHTML(view('pdf.print', compact('qdn')))->stream();
	}

//=============================== QDN ISSUANCE =======================================================
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
			$qdn = $this->qdn->add($request);

			Event::fire(new EventLogs($this->qdn->user, 'issue QDN: ' . $qdn->control_id));
			Event::fire(new EmailQdnNotificationEvent($qdn));
			Flash::success('Success! Team responsible will be notified regarding the issue via email!');
		}

		return redirect('/');
	}

	//========================================== PE VERIFICATION =====================================
	/**
	 * view controller for issued QDN
	 * @param  [type] $slug [description]
	 * @return [type]       [description]
	 */
	public function show(Info $slug) {
		$active_user = $this->qdn->cacheQdn($slug);
		if ($active_user == $this->qdn->user->employee->name) {
			return $this->qdn->view($slug, 'report.view');
		} else {
			Flash::warning('Notice: You are redirected to home page for the reason that the page is currently used by ' . $active_user);
			return redirect('/');
		}

	}

	/**
	 * method in section one that will save the status if pe decided to validate qdn
	 * @param Request $request [description]
	 * @param Info    $slug    [description]
	 */
	public function SectionOneSaveAndProceed(Request $request, Info $slug) {
		$this->qdn->SectionOneUpdate($request, $slug);
		$this->qdn->UpdateClosureStatus($request, $slug);
		return redirect('/');
	}

	/**
	 * Save section one as drop if pe are not yet decided (AJAX request)
	 * @param Request $request [description]
	 * @param Info    $slug    [description]
	 */
	public function SectionOneSaveAsDraft(Request $request, Info $slug) {
		$collection = $this->qdn->SectionOneUpdate($request, $slug);
		Event::fire(new EventLogs($this->qdn->user, 'P.E. save as draft and not yet validate' . $slug->control_id));
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
		Event::fire(new EventLogs($this->qdn->user, 'Incomplete: save as draft' . $slug->control_id));
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

		Event::fire(new EventLogs($this->qdn->user, 'Incomplete: save and proceed' . $slug->control_id));
		Event::fire(new ApprovalNotificationEvent($slug, 'Answered by' . $this->qdn->user->employee->name));
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
		return $this->qdn->view($slug, 'report.IncompleteApproval');}

	/**
	 * approval post method that update cycletime and closure table
	 * @param Info $slug [description]
	 */
	public function UpdateForApprroval(Info $slug, Request $request) {
		$this->qdn->approverUpdate($request, $slug); //update closure and qdncycle table
		return redirect('/');
	}

//================================= FOR QA VERIFICATION ==================================================
	/**
	 * view of qdn that are for closure
	 * @param Info $slug [description]
	 */
	public function QaVerification(Info $slug) {
		return $this->qdn->view($slug, 'report.QaVerification');
	}

	public function QaVerificationUpdate(Info $slug, Request $request) {
		$this->qdn->sectionEigthClosure($slug, $request); // update qdn closures
		return redirect('/'); // view home page
	}
}
