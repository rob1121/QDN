<?php namespace App\repo\File;


use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class cod extends ActionExtension implements ObjectiveEvidenceInterface
{
    protected $year;
    protected $controlId;

    /**
     * @param $info
     * @param $request
     */
    public function update($info, $request)
    {
        $arr = [
            'cause_of_defect' => $request->cause_of_defect,
            'cause_of_defect_description' => $request->cause_of_defect_description,
            'objective_evidence' => $this->upload($info, $request),
        ];

        $info->CauseOfDefect()->update($arr);
    }
    
    /**
     * @param $info
     * @param $request
     * @return string
     */
    private function upload($info, $request)
    {
        $this->year = Carbon::parse($info->created_at)->year;
        $this->controlId = $info->control_id;
        $this->name = "upload_cod";

        $oe = $info->causeOfDefect->objective_evidence;

        if ($request->hasFile($this->name))
        {
            if ($this->isNotEmpty($info->causeOfDefect) && $this->isExist($this->directory($oe)))
                Storage::delete($this->directory($oe));

            $this->moveFile($request);

            return $this->fileName($request);
        }

        return  $info->causeOfDefect->objective_evidence;
    }
}