<?php

namespace App\Http\Controllers;

use App\Http\Requests\QdnCreateRequest;
use App\Models\Info;
use App\repo\InfoRepository;
use Flash;
use Illuminate\Http\Request;
use PDF;

class reportController extends Controller {
	protected $qdn;

	public function __construct(InfoRepository $qdn) {
		$this->middleware('auth');
		$this->qdn = $qdn;
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
			$this->qdn->add($request);
			//send email notification
			// Event::fire(new EmailQdnNotificationEvent());
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
		return $this->qdn->view($slug, 'report.view');
	}

	/**
	 * for printing qdn form
	 * @param  [type] $slug [description]
	 * @return [type]       [description]
	 */
	public function pdf(Info $slug) {
		$qdn = $slug;
		return PDF::loadHTML(view('pdf.print', compact('qdn')))->stream();
		// return file_get_contents('/');
	}
}
