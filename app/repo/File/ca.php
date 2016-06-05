<?php namespace App\repo\File;


use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ca extends ActionExtension implements ObjectiveEvidenceInterface
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
            'what' => $request->corrective_action_textarea,
            'who' => $request->corrective_action_who,
            'objective_evidence' => $this->upload($info, $request)
        ];

        $info->CorrectiveAction()->update($arr);
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
        $this->name = "upload_corrective_action";
        
        $oe = $info->correctiveAction->objective_evidence;

        if ($request->hasFile($this->name))
        {
            if ($this->isNotEmpty($info->correctiveAction)
                && $this->isExist($this->directory($oe)))

                Storage::delete($this->directory($oe));

            $this->moveFile($request);
            
            return $this->fileName($request);
        }

        return $info->correctiveAction->objective_evidence;
    }
    

}