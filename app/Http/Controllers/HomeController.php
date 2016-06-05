<?php

namespace App\Http\Controllers;

use App\Models\Closure;
use App\Models\Info;
use App\repo\Exception\DataRelationNotFound;
use App\repo\Exception\ExceptionInterface;
use App\repo\HomeRepository;
use Auth;
use Illuminate\Http\Request;
use JavaScript;
use Str;

class HomeController extends Controller
{
    private $home;
    protected $user;

    /**
     * HomeController constructor.
     * @param HomeRepository $home
     */
    public function __construct(HomeRepository $home)
    {
        $this->home = $home;
        $this->user = Auth::user();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index()
    {
        return $this->user ? redirect('/home') : view('welcome');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function home()
    {
        JavaScript::put('yearNow', $this->home->dateTime()->year);
        return $this->user ? view('home') : redirect('/');
    }

    /**
     * array function for getting data for graphs
     * @param $collection
     * @return array
     */
    protected function arrayCollection($collection)
    {
        return $this->home->collection($collection);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function ajax(Request $request)
    {
        return $this->home->highChartData($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function qdnData(Request $request)
    {
        return view('home.qdnData')
            ->with('tbl', Info::issued($request->setDate)->get());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function AjaxStatus(Request $request)
    {
        $tbl = Closure::status(Str::title($request->status))->get();

        if ($tbl->load('info')->count() != $tbl->count())
            $this->error(new DataRelationNotFound);

        return view('home.status', ['tbl' => $tbl, 'link' => $this->link($request->status)]);
    }

    /**
     * @param $status
     * @return string
     * @throws \Exception
     */
    public function link($status)
    {
        switch ($status) {
            case 'p.e. verification':
                return 'qdn_link';
                break;

            case 'incomplete fill-up':
                return 'ForIncompleteFillUp';
                break;

            case 'incomplete approval':
                return 'approval';
                break;

            case 'q.a. verification':
                return 'qa_verification';
                break;
            default:
                throw new \Exception("no found valid type of status at " . __LINE__ . " of " . __FILE__);
                break;
        }
    }

    /**
     * @return array
     */
    public function counter()
    {
        return $this->home->counter();
    }

    /**
     * @param ExceptionInterface $throw
     */
    private function error(ExceptionInterface $throw)
    {
        $throw->exception();
    }
}