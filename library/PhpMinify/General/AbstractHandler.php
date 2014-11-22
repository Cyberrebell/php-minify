<?php

namespace PhpMinify\General;

abstract class AbstractHandler
{
	protected $fileFormat;
	
	protected function getFileEnding($fileName) {
		return substr($fileName, strrpos($fileName, '.') + 1);
	}
}