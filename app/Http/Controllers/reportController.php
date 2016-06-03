<?php

namespace App\Http\Controllers;

use App\Http\Requests\QdnCreateRequest;
use App\Models\Info;
use App\repo\Event\ApprovalEvent;
use App\repo\Event\DownloadEvent;
use App\repo\Event\DraftEvent;
use App\repo\Event\EventInterface;
use App\repo\Event\PeVerificationDraftEvent;
use App\repo\Event\StoreEvent;
use App\repo\Exception\DataRelationNotFound;
use App\repo\Exception\DuplicateDataException;
use App\repo\Exception\DuplicationException;
use App\repo\Exception\ExceptionInterface;
use App\repo\Exception\OneUserPolicyException;
use App\repo\File\ObjectiveEvidenceInterface;
use App\repo\InfoRepository;
use Auth;
use Cache;
use Event;
use Flash;
use Gate;
use Illuminate\Http\Request;
use PDF;

class reportController extends Controller
{
    protected $qdn;

    /**
     * reportController constructor.
     * @param InfoRepository $qdn
     */
    public function __construct(InfoRepository $qdn)
    {
        $this->middleware('auth');
        $this->qdn = $qdn;
    }

    /**
     * @param Info $slug
     * @return mixed
     */
    public function pdf(Info $slug)
    {
        $this->event(new DownloadEvent, $slug);

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
        $this->error(new DuplicateDataException);

        if (!$this->hasDuplicate($request)) {
            $qdn = $this->qdn->add($request);
            $this->event(new StoreEvent, $qdn);
        }

        return redirect(route('home'));
    }


    /**
     * @param Info $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function show(Info $slug)
    {
        return $this->guardView($slug, 'report.view');
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

        Cache::forget($slug->slug);
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
        $this->event(new PeVerificationDraftEvent, $slug);

        return array_add($request->all(), 'department', $collection['emp_dept']);
    }

    /**
     * @param Info $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ForIncompleteFillUp(Info $slug)
    {
        if (!$slug->involvePerson()->count())
            $this->error(new DataRelationNotFound);

        return $this->guardView($slug, 'report.incomplete');
    }

    /**
     * @param Info $slug
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function draft(Info $slug, Request $request)
    {
        $this->qdn->save($slug, $request);
        $this->event(new DraftEvent, $slug);

        Cache::forget($slug->slug);
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
        $this->event(new ApprovalEvent, $slug);

        Cache::forget($slug->slug);
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
        if ($this->qdn->approverUpdate($request, $slug))
            $this->qdn->updateStatusEvent($request, $slug);

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
     * @param Info $slug
     * @param $view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    private function guardView(Info $slug, $view)
    {
        $this->qdn->addCacheQdn($slug);
        if (Gate::allows('mod-qdn', $slug->slug)) return $this->qdn->view($slug, $view);

        $active_user = Cache::get($slug->slug);

        Flash::warning('Notice: Sorry, The page you are trying to access is currently used by ' . $active_user . ' please try again later');
        return redirect(route('home'));
    }

    /**
     * @param ExceptionInterface $throw
     */
    public function error(ExceptionInterface $throw)
    {
        $throw->exception();
    }

    /**
     * @param EventInterface $event
     * @internal param $qdn
     */
    private function event(EventInterface $event, $qdn)
    {
        $event->fire($qdn);
    }
}
