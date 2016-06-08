<?php namespace App\repo\File;


use App\Models\Info;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class pa extends ActionExtension implements ObjectiveEvidenceInterface {

    public function set(Info $info, Request $request)
    {
        $this->info = $info;
        $this->request = $request;

        $this->year = Carbon::parse($this->info->created_at)->year;
        $this->controlId = $this->info->control_id;
        $this->name = "upload_preventive_action";

        return $this;
    }

    public function upload()
    {
        $this->fileName = $this->request->hasFile($this->name)
            ? $this->isFileExist()->moveFile()->fileName()
            : $this->info->preventiveAction->objective_evidence;

        return $this;
    }

    public function save()
    {
        $this->info->PreventiveAction()
            ->update([
                'what' => $this->request->preventive_action_textarea,
                'who' => $this->request->preventive_action_who,
                'objective_evidence' => $this->fileName
            ]);
    }

    protected function isFileExist()
    {
        $oe = $this->info->preventiveAction->objective_evidence;

        if ($this->isNotEmpty($this->info->preventiveAction) && $this->isExist($this->directory($oe)))
            Storage::delete($this->directory($oe));

        return $this;
    }
}