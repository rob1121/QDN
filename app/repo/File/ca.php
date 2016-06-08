<?php namespace App\repo\File;


use App\Models\Info;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ca extends ActionExtension implements ObjectiveEvidenceInterface {

    public function set(Info $info, Request $request)
    {
        $this->info = $info;
        $this->request = $request;

        $this->year = Carbon::parse($this->info->created_at)->year;
        $this->controlId = $this->info->control_id;
        $this->name = "upload_corrective_action";

        return $this;
    }

    public function upload()
    {
        $this->fileName = $this->request->hasFile($this->name)
            ? $this->isFileExist()->moveFile()->fileName()
            : $this->info->correctiveAction->objective_evidence;

        return $this;
    }

    public function save()
    {
        $this->info->CorrectiveAction()
            ->update([
                'what' => $this->request->corrective_action_textarea,
                'who' => $this->request->corrective_action_who,
                'objective_evidence' => $this->fileName
            ]);
    }

    protected function isFileExist()
    {
        $oe = $this->info->correctiveAction->objective_evidence;

        if ($this->isNotEmpty($this->info->correctiveAction) && $this->isExist($this->directory($oe)))
            Storage::delete($this->directory($oe));

        return $this;
    }
}