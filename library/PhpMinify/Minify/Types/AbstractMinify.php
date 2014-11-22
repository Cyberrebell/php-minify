<?php

namespace PhpMinify\Minify\Types;

abstract class AbstractMinify
{
	protected $file;
	protected $fileContent;
	
	function __construct($file) {
		$this->file = $file;
	}
	
	abstract function minify();
	
	function getFileContent() {
		if ($this->fileContent === null) {
			$this->fileContent = file_get_contents($this->file);
		}
		return $this->fileContent;
	}
	
	function setFileContent($content) {
		$this->fileContent = $content;
	}
	
	function save() {
		file_put_contents($this->file, $this->fileContent);
	}
}
