<?php

namespace App\Http\Controllers;

use App\Events\ApprovalNotificationEvent;
use App\Events\EmailQdnNotificationEvent;
use App\Events\EventLogs;
use App\Http\Requests\QdnCreateRequest;
use App\Models\Info;
use App\repo\InfoRepository;
use Auth;
use Cache;
use Event;
use Flash;
use Gate;
use Illuminate\Http\Request;
use PDF;

class reportController extends Controller {
	protected $qdn;

	/**
	 * reportController constructor.
	 * @param InfoRepository $qdn
     */
	public function __construct(InfoRepository $qdn)
    {
		$this->middleware('auth');
		$this->qdn       = $qdn;
	}

	/**
	 * @param Info $slug
	 * @return mixed
     */
	public function pdf(Info $slug)
    {
		Event::fire(new EventLogs($this->qdn->user(), 'download' . $slug->control_id));

		return PDF::loadHTML(view('pdf.print', ['qdn' => $slug]))->stream();
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function report()
    {
		return view('report.create');
	}

	/**
	 * @param QdnCreateRequest $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
	public function store(QdnCreateRequest $request)
    {
        //check if has duplicate
		if($this->hasDuplicate($request))
		{
            //flash message nad redirect to home page
			Flash::warning('Oh Snap!! This QDN is already registered. In doubt? ask QA to assist you!');
			return redirect('/');
		}
        //insert request to database method and return table info
		$qdn = $this->qdn->add($request);
        //fire event method
		$this->storeQdnEvent($qdn);
        
        return redirect('/');
	}


    /**
     * @param Info $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function show(Info $slug)
    {
		$this->qdn->addCacheQdn($slug);

		if (Gate::allows('mod-qdn', $slug->slug)) return $this->qdn->view($slug, 'report.view');

		$active_user = Cache::get($slug->slug);
		Flash::warning('Notice: You are redirected to home page for the reason that the page you are trying to access is currently used by ' . $active_user);
		return redirect(route('home'));
	}

    /**
     * @param Request $request
     * @param Info $slug
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function SectionOneSaveAndProceed(Request $request, Info $slug)
    {
		$this->qdn->SectionOneUpdate($request, $slug);
		$this->qdn->UpdateClosureStatus($request, $slug);
		return redirect('/');
	}

    /**
     * @param Request $request
     * @param Info $slug
     * @return array
     */
    public function SectionOneSaveAsDraft(Request $request, Info $slug)
    {
		$collection = $this->qdn->SectionOneUpdate($request, $slug);
		Event::fire(new EventLogs($this->qdn->user(), 'P.E. save as draft and not yet validate' . $slug->control_id));
		return array_add($request->all(), 'department', $collection['emp_dept']);
	}


    /**
     * @param Info $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ForIncompleteFillUp(Info $slug)
    {
		return $this->qdn->view($slug, 'report.incomplete');
	}

    /**
     * @param Info $slug
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function draft(Info $slug, Request $request)
    {
		$this->qdn->save($slug, $request);
        $this->draftEvent($slug);

		return redirect('/');
	}

    /**
     * @param Info $slug
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function forApproval(Info $slug, Request $request)
    {
        $this->qdn->save($slug, $request);
        $slug->closure()->update(['status' => 'incomplete approval']);
        $this->forApprovalEvent($slug);

        return redirect('/');
	}

    /**
     * @param Info $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function approval(Info $slug)
    {
		return $this->qdn->view($slug, 'report.IncompleteApproval');
    }

    /**
     * @param Info $slug
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function UpdateForApprroval(Info $slug, Request $request)
    {
		$this->qdn->approverUpdate($request, $slug); //update closure and qdncycle table
		return redirect('/');
	}

    /**
     * @param Info $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function QaVerification(Info $slug)
    {
		return $this->qdn->view($slug, 'report.QaVerification');
	}

    /**
     * @param Info $slug
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function QaVerificationUpdate(Info $slug, Request $request)
    {
		$this->qdn->sectionEightClosure($slug, $request); // update qdn closures
		return redirect('/'); // view home page
	}

  /**
     * method call to refresh the cache for another 5 mins
     * @param $slug
     * @return mixed
     */
    public function CacheRefresher($slug)
    {
		Cache::add($slug, $this->qdn->user()->employee->name, 5);
		return $this->qdn->user()->employee->name;
	}

    /**
     * method call when user leave the page or detected intactive for 5 mins
     * @param $slug
     */
    public function ForgetCache($slug)
    {
		$this->qdn->forgetCache($slug);
	}

    /**
     * @param $request
     * @return bool
     */
    private function hasDuplicate($request)
    {
        return Info::isExist($request)->count() > 0;
    }

	/**
	 * @param $qdn
	 */
	private function storeQdnEvent($qdn)
	{
		Event::fire(new EventLogs($this->qdn->user(), 'issue QDN: ' . $qdn->control_id));
		Event::fire(new EmailQdnNotificationEvent($qdn));
        Flash::success('Success! Team responsible will be notified regarding the issue via email!');
	}

    /**
     * @param Info $slug
     */
    private function draftEvent(Info $slug)
    {
        Event::fire(new EventLogs($this->qdn->user(), 'Incomplete: save as draft' . $slug->control_id));
        Flash::success('Successfully save! Issued QDN are save as draft and still subject for completion!');
    }

    /**
     * @param Info $slug
     */
    private function forApprovalEvent(Info $slug)
    {
        Event::fire(new EventLogs($this->qdn->user(), 'Incomplete: save and proceed' . $slug->control_id));
        Event::fire(new ApprovalNotificationEvent($slug, 'Answered by' . $this->qdn->user()->employee->name));
        Flash::success('Successfully save! Issued QDN is now subject for Approval!');
    }

}
