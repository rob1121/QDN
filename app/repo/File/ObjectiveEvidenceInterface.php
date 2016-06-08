<?php namespace App\repo\File;


use App\Models\Info;
use Illuminate\Http\Request;

interface ObjectiveEvidenceInterface
{
    public function set(Info $info, Request $request);
    public function upload();
    public function save();
}