<?php namespace App\repo\File;


use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class pa extends ActionExtension implements ObjectiveEvidenceInterface
{

    /**
     * @param $info
     * @param $request
     */
    public function update($info, $request)
    {
        $arr = [
            'what' => $request->preventive_action_textarea,
            'who' => $request->preventive_action_who,
            'objective_evidence' => $this->upload($info, $request),
        ];

        $info->PreventiveAction()->update($arr);
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
        $this->name = "upload_preventive_action";
        
        $oe = $info->preventiveAction->objective_evidence;

        if ($request->hasFile($this->name))
        {
            if ($this->isNotEmpty($info->preventiveAction) && $this->isExist($this->directory($oe)))
                Storage::delete($this->directory($oe));

            $this->moveFile($request);
        }

        return isset($file)
            ? $file
            : $info->preventiveAction->objective_evidence;
    }
}