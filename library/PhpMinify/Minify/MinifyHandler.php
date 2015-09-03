<?php

namespace PhpMinify\Minify;

use PhpMinify\General\AbstractHandler;
use PhpMinify\Minify\Types\CssMinify;
use PhpMinify\Minify\Types\JsMinify;

class MinifyHandler extends AbstractHandler
{
    protected $file;
    
    public function __construct($file)
    {
        $this->file = $file;
        $this->fileFormat = $this->getFileEnding($this->file);
    }
    
    public function minify()
    {
        if ($this->fileFormat == 'css') {
            $minify = new CssMinify($this->file);
            $minify->minify();
        } elseif ($this->fileFormat == 'js') {
            $minify = new JsMinify($this->file);
            $minify->minify();
        } else {
            throw new \Exception("unknows file format. Can't minify this!");
        }
    }
}
