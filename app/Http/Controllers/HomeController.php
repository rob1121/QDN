<?php

namespace App\Http\Controllers;

use App\Models\Closure;
use App\Models\Info;
use App\repo\HomeRepository;
use Auth;
use Illuminate\Http\Request;
use JavaScript;
use Str;

class HomeController extends Controller {
	private $home;
	protected $user;

    /**
     * HomeController constructor.
     * @param HomeRepository $home
     */
    public function __construct(HomeRepository $home) {
		$this->home = $home;
		$this->user = Auth::user();
	}

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index() {
		return $this->user ? view('home') : view('welcome');
	}

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function home() {
		JavaScript::put('yearNow', $this->home->dateTime()->year);
		return $this->index();
	}

    /**
     * array function for getting data for graphs
     * @param $collection
     * @return array
     */
	protected function arrayCollection($collection) {
		return $this->home->collection($collection);
	}

    /**
     * @param Request $request
     * @return array
     */
    public function ajax(Request $request) {
		return $this->home->highChartData($request);
	}

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function qdnData(Request $request) {
		return view('home.qdnData')
            ->with('tbl', Info::issued($request->input('setDate'))->get());
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function AjaxStatus(Request $request) {
		return view('home.status')
            ->with('tbl', Closure::status(Str::title($request->input('status')))->get());
	}

	/**
	 * @return array
     */
	public function counter() {
		return $this->home->counter();
	}
}
