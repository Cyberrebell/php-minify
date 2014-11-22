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
	
	protected function save() {
		file_put_contents($this->file, $this->fileContent);
	}
	
	protected function removeComments() {
		$content = $this->getFileContent();
		
		$content = preg_replace('/\/\*([^.]+)\*\//', '', $content);
		
		$this->setFileContent($content);
	}
	
	protected function removeNewlines() {
		$content = $this->getFileContent();
		
		$content = str_replace("\n", '', $content);
		
		$this->setFileContent($content);
	}
	
	protected function removeSpaces() {
		$content = $this->getFileContent();
		
		$content = preg_replace('/;\s+/', ';', $content);
		$content = preg_replace('/:\s+/', ':', $content);
		$content = preg_replace('/\s+\{\s+/', '{', $content);
		$content = preg_replace('/;*\};?/', '};', $content);
		
		$this->setFileContent($content);
	}
}
