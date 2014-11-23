<?php

namespace PhpMinify\Minify\Types;

use PhpMinify\Minify\Types\AbstractMinify;

class CssMinify extends AbstractMinify
{
	function minify() {
		$this->removeNewlines();
		$this->removeComments();
		$this->removeSpaces();
		
		$this->save();
	}
	
	protected function removeSpaces() {
		$content = $this->getFileContent();
		
		$content = preg_replace('/;\s+/', ';', $content);
		$content = preg_replace('/:\s+/', ':', $content);
		$content = preg_replace('/\s+\{\s+/', '{', $content);
		$content = preg_replace('/;*\}/', '}', $content);
		
		$content = substr($content, 0, strlen($content) - 1);	//remove last ;
		
		$this->setFileContent($content);
	}
}
