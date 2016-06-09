<?php namespace App\repo\File;


use Illuminate\Support\Facades\Storage;

class ActionExtension
{
    protected $year;
    protected $controlId;
    protected $name;
    protected $info;
    protected $request;
    protected $fileName;

    /**
     * @param $directory
     * @return mixed
     */
    protected function isExist($directory)
    {
        return Storage::disk('local')->exists($directory);
    }
    
    protected function fileName()
    {
        return "{$this->name}." . $this->request->file($this->name)->guessClientExtension();
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
    
    protected function moveFile()
    {
        $this->request->file($this->name)->move($this->directory(), $this->fileName($this->request, $this->name));
        
        return $this;
    }

}