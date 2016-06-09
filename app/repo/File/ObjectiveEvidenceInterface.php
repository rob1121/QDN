<?php namespace App\repo\File;


use App\Models\Info;
use Illuminate\Http\Request;

interface ObjectiveEvidenceInterface
{
    /**
     * @param Request $request
     * @param Info $info
     * @return mixed
     */
    public function set(Info $info, Request $request);

    /**
     * @return mixed
     */
    public function upload();

    /**
     * @return mixed
     */
    public function save();
}