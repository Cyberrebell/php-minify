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
}
