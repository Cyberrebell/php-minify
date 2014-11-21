<?php

namespace PhpMinify\Glue;

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
	
	protected function checkFileFormatConsistence() {
		foreach ($this->inputFiles as $inputFile) {
			$ending = substr($inputFile, strpos($inputFile, '.', -1));
			if ($this->fileFormat) {
				if ($ending != $this->fileFormat) {
					throw new \Exception("invalid glue configuration. Can't glue ." . $ending . " file with ." . $this->fileFormat);
				}
			} else {
				$this->fileFormat = $ending;
			}
		}
		if ($this->fileFormat != $this->outputFile) {
			throw new \Exception("invalid glue configuration. Can't convert ." . $this->fileFormat . " files to ." . $this->outputFile);
		}
	}
}
