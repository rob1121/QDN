<?php

namespace App\Http\Controllers;

use App\Models\Info;
use App\repo\Db\DbQdnFillUpTransaction;
use App\repo\View\ViewPage;
use App\repo\Db\DbInfo;
use App\repo\Db\DbPeVerificationTransaction;
use App\repo\Event\QdnClosureEvent;
use App\repo\Event\StatusUpdateEvent;
use App\repo\Exception\DataRelationNotFound;
use App\repo\InfoRepository;
use Flash;
use Gate;
use Illuminate\Http\Request;
use PDF;

/**
 * Class reportController
 * @package App\Http\Controllers
 */
class reportController extends Controller {
    /**
     * @var InfoRepository
     */
    public $qdn;

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
        return ViewPage::PDF($slug);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function report()
    {
        return view('report.create');
    }

    /**
     * @param DbInfo $qdn
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(DbInfo $qdn)
    {
        $qdn->store();

        return redirect(route('home'));
    }

    /**
     * @param ViewPage $view
     * @param Info $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function show(ViewPage $view, Info $slug)
    {
        return $view->display($slug, 'report.view');
    }

    /**
     * @param DbPeVerificationTransaction $db
     * @param Info $slug
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function SectionOneSaveAndProceed(DbPeVerificationTransaction $db, Info $slug)
    {
        $db->save($slug)
            ->PeVerificationEvent();
        
        return redirect('/');
    }

    /**
     * @param DbPeVerificationTransaction $db
     * @param Info $slug
     * @return mixed
     */
    public function SectionOneSaveAsDraft(DbPeVerificationTransaction $db, Info $slug)
    {
        return $this->save($slug)
            ->PeVerificationDraftEvent()
            ->collection();
    }

    /**
     * @param ViewPage $view
     * @param Info $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function ForIncompleteFillUp(ViewPage $view, Info $slug)
    {
        return $view->display($slug, 'report.incomplete');
    }

    /**
     * @param DbQdnFillUpTransaction $db
     * @param Info $slug
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function draft(DbQdnFillUpTransaction $db, Info $slug)
    {
        $db->saveAsDraft($slug);

        return redirect(route('home'));
    }

    /**
     * @param DbQdnFillUpTransaction $db
     * @param Info $slug
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function forApproval(DbQdnFillUpTransaction $db, Info $slug)
    {
        $db->saveAndProceed($slug);

        return redirect(route('home'));
    }

    /**
     * @param ViewPage $view
     * @param Info $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function approval(ViewPage $view, Info $slug)
    {
        return $view->display($slug, 'report.IncompleteApproval');
    }

    public function UpdateForApprroval(Info $slug, Request $request)
    {
        if ($this->qdn->approverUpdate($request, $slug))
            $this->qdn->event(new StatusUpdateEvent, ['info' => $slug, 'request' => $request]);

        return redirect(route('home'));
    }

    /**
     * @param ViewPage $view
     * @param Info $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function QaVerification(ViewPage $view, Info $slug)
    {
        return $view->display($slug, 'report.IncompleteApproval');
    }

    public function QaVerificationUpdate(Info $slug, Request $request)
    {
        $this->qdn->sectionEightClosure($slug, $request); // update qdn closures
        $this->event(new QdnClosureEvent, ['info' => $slug, 'request' => $request]);
        return redirect(route('home')); // view home page
    }

    /**
     * @param ViewPage $view
     * @param Info $slug
     */
    public function CacheRefresher(ViewPage $view, Info $slug)
    {
        $view->qdn = $slug;

        $view->deleteCache();
    }

    /**
     * @param ViewPage $view
     * @param Info $slug
     */
    public function ForgetCache(ViewPage $view, Info $slug)
    {
        $view->qdn = $slug;
        
        $view->deleteCache();
    }
}
