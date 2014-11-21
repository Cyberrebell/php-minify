<?php

namespace PhpMinify\Glue;

use PhpMinify\Glue\Types\CssGlue;

class GlueHandler
{
	protected $inputFiles;
	protected $outputFile;
	protected $fileFormat;
	
	function __construct(array $inputFiles, $outputFile) {
		$this->inputFiles = $inputFiles;
		$this->outputFile = $outputFile;
		$this->checkFileFormatConsistence();
	}
	
	function glue() {
		if ($this->fileFormat == 'css') {
			$glue = new CssGlue();
		} else if ($this->fileFormat == 'js') {
			//todo
		} else {
			throw new \Exception("unknows file format. Can't glue this!");
		}
	}
	
	protected function checkFileFormatConsistence() {
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
	
	protected function getFileEnding($fileName) {
		return substr($fileName, strrpos($fileName, '.') + 1);
	}
}
