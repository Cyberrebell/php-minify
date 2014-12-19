<?php

namespace PhpMinify\Minify\Types\JsMinify;

class JsCode
{
	protected static $spaceChars = [' ', "\t", PHP_EOL];
	protected $segments = [];
	
	function __construct($code) {
		$this->segments = $this->resolveCodeToSegments($code);
	}
	
	function __toString() {
		$output = '';
		foreach ($this->segments as $segment) {
			$output .= $segment;
		}
		return $output;
	}
	
	protected function resolveCodeToSegments ($code) {
		$codeLength = strlen($code);
		for ($i = 0; $i < $codeLength; $i++) {
			if (in_array($code[$i], self::$spaceChars, true)) {
				continue;
			} else {
				$nextWord = $this->getNextWord($code, $i);
				switch ($nextWord) {
					case 'var':
						$varName = $this->getNextWord($code, $i + 3);
						var_dump($varName); exit;
						break;
					case 'function':
						break;
					case 'if':
						break;
					case 'for':
						break;
					case 'switch':
						break;
					case false:
						break;
					default:
						//global var
						break;
				}
			}
		}
	}
	
	protected function getNextWord($code, $offset = 0) {
		$nextSpace = false;
		foreach (self::$spaceChars as $char) {
			$nextOfThisChar = strpos($code, $char, $offset);
			if ($nextOfThisChar && ($nextSpace === false || $nextOfThisChar < $nextSpace)) {
				$nextSpace = $nextOfThisChar;
			}
		}
		
		if ($nextSpace === false) {
			return false;
		} else {
			return substr($code, $offset, $nextSpace - $offset);
		}
	}
}
