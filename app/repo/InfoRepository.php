<?php namespace App\repo;

use App\Models\Info;
use App\repo\Traits\DateTime;
use Carbon;
use DB;
use JavaScript;
use Str;

class InfoRepository {
    
    use DateTime;

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
}