<?php

namespace App\Http\Controllers;

use App\Http\Requests\QdnCreateRequest;
use App\Models\Info;
use App\repo\Event\ApprovalEvent;
use App\repo\Event\DownloadEvent;
use App\repo\Event\DraftEvent;
use App\repo\Event\PeVerificationDraftEvent;
use App\repo\Event\QdnClosureEvent;
use App\repo\Event\StatusUpdateEvent;
use App\repo\Event\StoreEvent;
use App\repo\Exception\DataRelationNotFound;
use App\repo\Exception\DuplicateDataException;
use App\repo\InfoRepository;
use Cache;
use Flash;
use Gate;
use Illuminate\Http\Request;
use PDF;

class reportController extends Controller {
    public $qdn;

    public function __construct(InfoRepository $qdn)
    {
        $this->middleware('auth');
        $this->qdn = $qdn;
    }

    public function pdf(Info $slug)
    {
        $this->qdn->event(new DownloadEvent, $slug);

        return PDF::loadHTML(view('pdf.print', ['qdn' => $slug]))->stream();
    }

    public function report()
    {
        return view('report.create');
    }

    public function store(QdnCreateRequest $request)
    {
        $this->qdn->error(new DuplicateDataException);

        if ( ! $this->hasDuplicate($request)) {
            $qdn = $this->qdn->add($request);
            $this->qdn->event(new StoreEvent, $qdn);
        }

        return redirect(route('home'));
    }
    
    /**
     * @param Info $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function show(Info $slug)
    {
        return $this->qdn->guardView($slug, 'report.view');
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
        $this->qdn->event(new PeVerificationDraftEvent, $slug);

        return array_add($request->all(), 'department', $collection['emp_dept']);
    }

    /**
     * @param Info $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ForIncompleteFillUp(Info $slug)
    {
        if (!$slug->involvePerson()->count())
            $this->qdn->error(new DataRelationNotFound);

        return $this->qdn->guardView($slug, 'report.incomplete');
    }

    /**
     * @param Info $slug
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function draft(Info $slug, Request $request)
    {
        $this->qdn->save($slug, $request);
        $this->qdn->event(new DraftEvent, $slug);

        Cache::forget($slug->slug);

        return redirect(route('home'));
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
        $this->qdn->event(new ApprovalEvent, $slug);

        Cache::forget($slug->slug);

        return redirect(route('home'));
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
            $this->qdn->event(new StatusUpdateEvent, ['info' => $slug, 'request' => $request]);

        return redirect(route('home'));
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
        $this->event(new QdnClosureEvent, ['info' => $slug, 'request' => $request]);
        return redirect(route('home')); // view home page
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
}
