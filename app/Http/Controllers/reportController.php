<?php

namespace App\Http\Controllers;

use App\Models\Info;
use App\repo\Db\DbQdnFillUpTransaction;
use App\repo\Event\DraftEvent;
use App\repo\View\ViewPage;
use App\repo\Db\DbInfo;
use App\repo\Db\DbPeVerificationTransaction;
use App\repo\Event\ApprovalEvent;
use App\repo\Event\DownloadEvent;
use App\repo\Event\QdnClosureEvent;
use App\repo\Event\StatusUpdateEvent;
use App\repo\Exception\DataRelationNotFound;
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

    public function store(DbInfo $qdn)
    {
        $qdn->store();

        return redirect(route('home'));
    }

    public function show(ViewPage $view, Info $slug)
    {
        return $view->set($slug, 'report.view')
            ->createCache()
            ->display();
    }

    public function SectionOneSaveAndProceed(DbPeVerificationTransaction $db, Info $slug)
    {
        $db->setQdn($slug)
            ->save()
            ->PeVerificationEvent();
        
        return redirect('/');
    }

    public function SectionOneSaveAsDraft(DbPeVerificationTransaction $db, Info $slug)
    {
        return $db->setQdn($slug)
            ->save()
            ->PeVerificationDraftEvent()
            ->collection();
    }

    public function ForIncompleteFillUp(ViewPage $view, Info $slug)
    {
        return $view->set($slug, 'report.incomplete')
            ->createCache()
            ->display();
    }
    
    public function draft(DbQdnFillUpTransaction $db, Info $slug)
    {
        $db->setQdn($slug)
            ->save()
            ->deleteCache()
            ->event(new DraftEvent);

        return redirect(route('home'));
    }

    public function forApproval(DbQdnFillUpTransaction $db, Info $slug)
    {
        $db->setQdn($slug)
            ->save()
            ->updateStatus()
            ->deleteCache()
            ->event(new ApprovalEvent);

        return redirect(route('home'));
    }

    public function approval(ViewPage $view, Info $slug)
    {
        return $view->set($slug, 'report.IncompleteApproval')
            ->display();
    }
    
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
        if (Gate::allows('mod-qdn', $slug))
            Cache::forget($slug);
    }
}
