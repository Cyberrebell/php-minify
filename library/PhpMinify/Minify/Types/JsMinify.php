<?php

namespace PhpMinify\Minify\Types;

use PhpMinify\Minify\Types\AbstractMinify;
use PhpMinify\Minify\Types\JsMinify\JsCode;

class JsMinify extends AbstractMinify
{
	function minify() {
// 		$this->removeMultilineComments();
// 		$this->removeOneLineComments();
// 		$this->removeNewlines();
// 		$this->removeSpaces();

		$this->parseJsCode();
		
		$this->save();
	}
	
	protected function parseJsCode() {
		$content = $this->getFileContent();

		$jsCode = new JsCode($content);
		
		$this->setFileContent($jsCode);
	}
}
