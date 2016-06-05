<?php namespace App\repo\File;


use Illuminate\Support\Facades\Storage;

class ActionExtension
{
    protected $year;
    protected $controlId;
    protected $name;

    /**
     * @param $directory
     * @return mixed
     */
    protected function isExist($directory)
    {
        return Storage::disk('local')->exists($directory);
    }

    /**
     * @param $request
     * @return string
     */
    protected function fileName($request)
    {
        return "{$this->name}." . $request->file($this->name)->guessClientExtension();
    }

    /**
     * @param string $file
     * @return string
     */
    protected function directory($file = '')
    {
        return public_path() . "/objective_evidence/{$this->year}/{$this->controlId}/{$file}";
    }

    /**
     * @param $info
     * @return bool
     */
    protected function isNotEmpty($info)
    {
        return "" != $info->objective_evidence;
    }

    /**
     * @param $request
     */
    protected function moveFile($request)
    {
        $request->file($this->name)->move($this->directory(), $this->fileName($request, $this->name));
    }

}