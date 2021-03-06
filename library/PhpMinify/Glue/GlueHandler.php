<?php

namespace PhpMinify\Glue;

use PhpMinify\Glue\Types\CssGlue;
use PhpMinify\General\AbstractHandler;
use PhpMinify\Glue\Types\JsGlue;

class GlueHandler extends AbstractHandler
{
    protected $inputFiles;
    protected $outputFile;
    
    public function __construct(array $inputFiles, $outputFile)
    {
        $this->inputFiles = $inputFiles;
        $this->outputFile = $outputFile;
        $this->checkFileFormatConsistence();
    }
    
    public function glue()
    {
        if ($this->fileFormat == 'css') {
            $glue = new CssGlue($this->inputFiles, $this->outputFile);
            $glue->glue();
            $glue->cleanup();
        } elseif ($this->fileFormat == 'js') {
            $glue = new JsGlue($this->inputFiles, $this->outputFile);
            $glue->glue();
            $glue->cleanup();
        } else {
            throw new \Exception("unknows file format. Can't glue this!");
        }
    }
    
    protected function checkFileFormatConsistence()
    {
        foreach ($this->inputFiles as $inputFile) {
            $ending = $this->getFileEnding($inputFile);
            if ($this->fileFormat) {
                if ($ending != $this->fileFormat) {
                    throw new \Exception("invalid glue configuration. Can't glue " . $ending . " file with " . $this->fileFormat);
                }
            } else {
                $this->fileFormat = $ending;
            }
        }
        $outputFileFormat = $this->getFileEnding($this->outputFile);
        if ($this->fileFormat != $outputFileFormat) {
            throw new \Exception("invalid glue configuration. Can't convert " . $this->fileFormat . " files to " . $outputFileFormat);
        }
    }
}
