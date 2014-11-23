<?php

namespace PhpMinify\Minify\Types;

use PhpMinify\Minify\Types\AbstractMinify;

class JsMinify extends AbstractMinify
{
	function minify() {
		$this->removeMultilineComments();
		$this->removeOneLineComments();
// 		$this->removeNewlines();
// 		$this->removeSpaces();
		
		$this->save();
	}
	
	protected function removeSpaces() {
		$content = $this->getFileContent();
		
// 		$content = preg_replace('/;\s+/', ';', $content);
// 		$content = preg_replace('/:\s+/', ':', $content);
// 		$content = preg_replace('/\s+\{\s+/', '{', $content);
// 		$content = preg_replace('/;*\}/', '}', $content);
		
		$this->setFileContent($content);
	}
}
