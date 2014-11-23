<?php

namespace PhpMinify\Glue\Types;

use PhpMinify\Glue\Types\AbstractGlue;

class JsGlue extends AbstractGlue
{
	function glue() {
		foreach ($this->inputFiles as $inputFile) {
			$this->appendOutput(file_get_contents($inputFile));
		}
	}
}
