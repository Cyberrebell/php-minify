<?php

namespace PhpMinify\Minify;

use PhpMinify\General\AbstractHandler;
use PhpMinify\Minify\Types\CssMinify;

class MinifyHandler extends AbstractHandler
{
	protected $file;
	
	function __construct($file) {
		$this->file = $file;
	}
	
	function minify() {
		if ($this->fileFormat == 'css') {
			$minify = new CssMinify($this->file);
			$minify->minify();
		} else if ($this->fileFormat == 'js') {
			//todo
		} else {
			throw new \Exception("unknows file format. Can't minify this!");
		}
	}
}
