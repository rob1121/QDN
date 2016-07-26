<?php namespace App\Http\Controllers;

use Activity;
use App\Models\Closure;
use App\Models\Info;
use App\Models\InvolvePerson;
use App\repo\API\QdnCountAndData;
use App\repo\HomeRepository;
use App\repo\Traits\DateTime;
use Auth;
use Illuminate\Http\Request;
use JavaScript;
use Str;
use Gate;

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
//        return $this->user ? redirect('/home') : view('welcome');
        return $this->user ? redirect('/home') : view('index');
    }

    public function home(QdnCountAndData $qdn)
    {
        JavaScript::put([
            'yearNow' => $this->year(),
            'link' => [
                'status' => '/status',
                'ajax' => '/ajax',
                'qdn_data' => '/qdn_data'
            ],
            'qdn' => $qdn->getStatus()
        ]);
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
            ->with('tbl', Info::issuedFrom($request->setDate));
    }

    public function getQdnLinkAndData(Request $request)
    {
        return Closure::status($request->status)
        ->map(function($item) {
            array_add( $item, 'action_link', static::actionLink($item));
            array_add($item, 'gate', Gate::allows('mod-qdn', $item->info->slug));
            return array_add($item, 'receiver_name', InvolvePerson::getInvolvePerson($item->info_id));
        });
    }

    public static function actionLink($item) {
        $baseRoute = static::link( Str::lower( $item->status ) );
        $param = ['slug' => $item->info->slug];
        $url = route( $baseRoute , $param );

        return Gate::allows('mod-qdn', $item->info->slug) ? "<a href='{$url}'>{$item->info->control_id}</a>" : "(is active at the moment)";
    }

    public static function link($status)
    {
        return collect([
            'p.e. verification' => 'link_for_pe_verification',
            'incomplete fill-up' => 'ForIncompleteFillUp',
            'incomplete approval' => 'approval',
            'q.a. verification' => 'qa_verification',
            'closed' => 'pdf'
        ])->get($status);
    }

    public function counter()
    {
        return $this->home->counter();
    }
}