<?php

namespace App\Http\Controllers;

use App\Models\Closure;
use App\Models\Info;
use App\repo\Exception\DataRelationNotFound;
use App\repo\Exception\ExceptionInterface;
use App\repo\HomeRepository;
use App\repo\Traits\DateTime;
use Auth;
use Illuminate\Http\Request;
use JavaScript;
use Activity;
use Str;

class HomeController extends Controller
{
    use DateTime;

    private $home;
    protected $user;

    public function __construct(HomeRepository $home)
    {
        $this->home = $home;
        $this->user = Auth::user();
    }

    public function index()
    {
        return $this->user ? redirect('/home') : view('welcome');
    }

    public function home()
    {
        JavaScript::put('yearNow', $this->year());
        return $this->user ? view('home') : redirect('/');
    }

    protected function arrayCollection($collection)
    {
        return $this->home->collection($collection);
    }

    public function ajax(Request $request)
    {
        return $this->home->highChartData($request);
    }

    public function qdnData(Request $request)
    {
        return view('home.qdnData')
            ->with('tbl', Info::issued($request->setDate)->get());
    }

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
        $routes = collect([
            'p.e. verification' => 'qdn_link',
            'incomplete fill-up' => 'ForIncompleteFillUp',
            'incomplete approval' => 'approval',
            'q.a. verification' => 'qa_verification',
            'closed' => 'pdf'
        ])->get($status);

        return $routes;
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