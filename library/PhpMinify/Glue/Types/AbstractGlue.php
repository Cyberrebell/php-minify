<?php

namespace PhpMinify\Glue\Types;

abstract class AbstractGlue
{
	protected $inputFiles;
	protected $outputFile;
	protected $outputFileHandle;
	
	function __construct(array $inputFiles, $outputFile) {
		$this->inputFiles = $inputFiles;
		$this->outputFile = $outputFile;
	}
	
	abstract function glue();
	
	function cleanup() {
		$this->closeOutputFileHandle();
	}
	
	protected function appendOutput($string) {
		$handle = $this->getOutputFileHandle();
		fwrite($handle, $string);
	}
	
	protected function getOutputFileHandle() {
		if ($this->outputFileHandle === null) {
			if (file_exists($this->outputFile)) {
				unlink($this->outputFile);
			}
			$this->outputFileHandle = fopen($this->outputFile, 'a');
		}
		return $this->outputFileHandle;
	}
	
	protected function closeOutputFileHandle() {
		fclose($this->outputFileHandle);
	}
}
