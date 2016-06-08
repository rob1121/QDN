<?php namespace App\repo\File;


use App\Models\Info;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class cod extends ActionExtension implements ObjectiveEvidenceInterface {

    public function set(Info $info, Request $request)
    {
        $this->info = $info;
        $this->request = $request;

        $this->year = Carbon::parse($this->info->created_at)->year;
        $this->controlId = $this->info->control_id;
        $this->name = "upload_cod";

        return $this;
    }

    public function upload()
    {
        $this->fileName = $this->request->hasFile($this->name)
            ? $this->isFileExist()->moveFile()->fileName()
            : $this->info->causeOfDefect->objective_evidence;

        return $this;
    }

    public function save()
    {
        $this->info->CauseOfDefect()
            ->update([
                'cause_of_defect' => $this->request->cause_of_defect,
                'cause_of_defect_description' => $this->request->cause_of_defect_description,
                'objective_evidence' => $this->fileName,
            ]);
    }

    protected function isFileExist()
    {
        $oe = $this->info->causeOfDefect->objective_evidence;

        if ($this->isNotEmpty($this->info->causeOfDefect) && $this->isExist($this->directory($oe)))
            Storage::delete($this->directory($oe));

        return $this;
    }
}