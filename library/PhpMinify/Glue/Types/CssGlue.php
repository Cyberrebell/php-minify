<?php

namespace PhpMinify\Glue\Types;

use PhpMinify\Glue\Types\AbstractGlue;

class CssGlue extends AbstractGlue
{
	function glue() {
		foreach ($this->inputFiles as $inputFile) {
			$this->appendOutput(file_get_contents($inputFile));
		}
		
		$this->ensureUniqueCharset();
	}
	
	protected function ensureUniqueCharset() {
		$combined = file_get_contents($this->outputFile);
		$nextSearchOffset = 0;
		$charsetToUse = null;
		while (($charsetPos = stripos($combined, '@CHARSET', $nextSearchOffset)) !== false) {
			$endOfLine = strpos($combined, ";", $charsetPos);
			$nextNewlinePos = strpos($combined, "\n", $charsetPos);
			if ($nextNewlinePos < $endOfLine) {
				$endOfLine = $nextNewlinePos;
			}
			
			$charset = substr($combined, $charsetPos, ($endOfLine - $charsetPos) + 1);
			if ($charsetToUse && strnatcasecmp(substr($charset, 0, -1), substr($charsetToUse, 0, -1)) != 0) {	//compare without ; or \n
				throw new \Exception("found different charsets in css-files to glue. Please use the same charsets in each file");
			}
			$charsetToUse = $charset;
			$combined = substr($combined, 0, $charsetPos) . substr($combined, $endOfLine + 1);
			$nextSearchOffset = $charsetPos;
		}
		$combined = $charsetToUse . $combined;
		file_put_contents($this->outputFile, $combined);
	}
}
