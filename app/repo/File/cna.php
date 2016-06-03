<?php namespace App\repo\File;


use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class cna extends ActionExtension implements ObjectiveEvidenceInterface
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
            'what' => $request->containment_action_textarea,
            'who' => $request->containment_action_who,
            'objective_evidence' => $this->upload($info, $request),
        ];

        $info->ContainmentAction()->update($arr);
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
        $this->name = "upload_containment_action";
        
        $oe = $info->containmentAction->objective_evidence;

        if ($request->hasFile($this->name))
        {
            if ($this->isNotEmpty($info->containmentAction)
                && $this->isExist($this->directory($oe)))

                Storage::delete($this->directory($oe));

            $this->moveFile($request);
        }

        return isset($file)
            ? $file
            : $info->containmentAction->objective_evidence;
    }
    
}