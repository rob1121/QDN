<?php namespace App\repo;

use App\Employee;
use App\Models\Closure;
use App\Models\Info;
use App\Models\InvolvePerson;
use App\repo\Event\ClosureStatusEvent;
use App\repo\Event\EventInterface;
use App\repo\Event\ViewEvent;
use App\repo\Exception\ExceptionInterface;
use App\repo\Exception\InAppropriateClosureStatusException;
use App\repo\File\cod;
use App\repo\File\cna;
use App\repo\File\ca;
use App\repo\File\pa;
use App\repo\File\ObjectiveEvidenceInterface;
use App\repo\Traits\DateTime;
use Cache;
use Carbon;
use DB;
use Illuminate\Support\Facades\Gate;
use JavaScript;
use Laracasts\Flash\Flash;
use Str;

class InfoRepository {
    
    use DateTime;
	/**
	 * @param $qdn
	 * @param $view
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
	public function view($qdn, $view)
    {
		$this->event(new ViewEvent, $qdn);

        $links = [
            'linkDraft' => route('draft_link', ['slug' => $qdn->slug]),
            'linkApproval' => route('approval_link', ['slug' => $qdn->slug])
        ];
        
        JavaScript::put([
			'link' => $links,
			'qdn' => $qdn
		]);

		return view($view, compact('qdn'));
	}

    /**
     * @param $request
     * @param $qdn
     * @return bool
     */
    public function approverUpdate($request, $qdn)
    {

		$user = user()->employee;

        if ('reject' == $request->approver_radio)
        {
            $qdn->closure()->update(['status' => 'Incomplete Fill-Up', $user->department  => '']);
            return 'false';
        }

        $this->updateClosureTable($qdn, $user);
        $this->updateApproveStatus($qdn);
        
        return 'true';
	}

    /**
     * @param $qdn
     * @return int
     */
    public function statusOf($qdn)
    {
		$closure     = Info::whereSlug($qdn->slug)->with('closure')->first();
		$closure = $closure->closure;
        $booleanClosure = $closure->other_department && $closure->production && $closure->quality_assurance && $closure->process_engineering;

        if ($booleanClosure && $qdn->status == 'Q.a. Verification')
            $this->error(new InAppropriateClosureStatusException);

        return $booleanClosure;
	}

    /**
     * @param $qdn
     * @param $request
     */
    public function sectionEightClosure($qdn, $request)
    {
		Closure::where('info_id', $qdn->id)
			->update([
				'containment_action_taken' => $request->containment_action_taken,
				'corrective_action_taken'  => $request->corrective_action_taken,
				'close_by'                 => user()->employee->name,
				'date_sign'                => $this->date(),
				'status'                   => 'closed',
			]);
	}

    /**
     * @param $type
     * @param $qdn
     * @return mixed
     */
    public function count($type, $qdn)
    {
		return $qdn->where('failure_mode', $type)->count();
	}

    /**
     * @return mixed
     */
    public function getQdn()
    {
		$infoForMonth = Info::where(DB::raw('YEAR(created_at)'), $this->year())
			->where(DB::raw('MONTH(created_at)'), $this->month())
			->get();

		$infoForYear = Info::where(DB::raw('YEAR(created_at)'), $this->year())->get();

		return '' == $this->setMonth ? $infoForYear : $infoForMonth;
	}

    /**
     * @return mixed
     */
    public function failureModeCount()
    {
		$qdn = $this->getQdn();
        return collect(['assembly', 'environment', 'machine', 'man', 'material', 'method / process'])
            ->flatMap(function($fm) use($qdn) {
                $fm = Str::title($fm);
                return [$fm => count($qdn) ? $this->count($fm, $qdn) : 0];
            })->toArray();
	}

    /**
     * @return mixed
     */
    public function failureModeAve()
    {
		$qdn = $this->getQdn();
		$ave = $this->failureModeCount();

		if (array_sum($this->failureModeCount()))
			foreach ($this->failureModeCount() as $key => $value)
				$ave[$key] = round($this->count($key, $qdn) / array_sum($this->failureModeCount()) * 100);

		return $ave;
	}

    /**
     * @param $qdn
     */
    public function addCacheQdn($qdn)
    {
		Cache::add($qdn->slug, user()->employee->name, 5);
	}

    /**
     * @param EventInterface $event
     * @param $qdn
     */
    public function event(EventInterface $event, $qdn)
    {
        $event->fire($qdn);
    }

    /**
     * @param ExceptionInterface $throw
     */
    public function error(ExceptionInterface $throw)
    {
        $throw->exception();
    }

    public function getInvolvePersonStation($request)
    {
        return collect(array_unique($request->receiver_name))->map(function($name){
            return Employee::whereName($name)->first()->station;
        });
    }

    /**
     * @param $qdn
     */
    private function updateApproveStatus($qdn)
    {
        $status['status'] = $this->statusOf($qdn)
            ? 'Q.a. Verification'
            : 'Incomplete Approval';

        $qdn->closure()->update($status);
    }

    /**
     * @param $qdn
     * @param $user
     */
    private function updateClosureTable($qdn, $user)
    {
        $closure = [$user->department => $user->name];

        if (hasNoOtherDepartmentInvolve($user, $qdn))
            $closure['other_Department'] = $user->name;

        $qdn->closure()->update($closure);
    }

    /**
     * @param Info $slug
     * @param $view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function guardView(Info $slug, $view)
    {
        $this->addCacheQdn($slug);
        if (Gate::allows('mod-qdn', $slug->slug)) return $this->view($slug, $view);

        $active_user = Cache::get($slug->slug);

        Flash::warning('Notice: Sorry, The page you are trying to access is currently used by ' . $active_user . ' please try again later');
        return redirect(route('home'));
    }
}