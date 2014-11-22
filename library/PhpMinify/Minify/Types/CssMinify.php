<?php

namespace PhpMinify\Minify\Types;

use PhpMinify\Minify\Types\AbstractMinify;

class CssMinify extends AbstractMinify
{
	function minify() {
		$content = $this->getFileContent();
		
		
		
		$this->save();
	}
}
