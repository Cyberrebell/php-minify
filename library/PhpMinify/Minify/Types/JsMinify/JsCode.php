<?php

namespace PhpMinify\Minify\Types\JsMinify;

class JsCode
{
	protected static $spaceChars = [' ', "\t", PHP_EOL];
	protected static $skipChars = [];
	protected static $scopeOpenChars = ['(', '{'];
	protected static $scopeCloseChars = [')', '}'];
	protected static $stringLimiterChars = ["'", '"'];
	protected $segments = [];
	
	function __construct($code) {
		self::$skipChars = array_merge(self::$skipChars, self::$spaceChars);
		$this->resolveCodeToSegments($code);
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
			if (in_array($code[$i], self::$stringLimiterChars, true)) {	//handle strings
				preg_match('/' . $code[$i] . '.*(?<!\\\\)' . $code[$i] . '/U', substr($code, $i), $match);
				$match = reset($match);
				$this->segments[] = $match;
				$i += strlen($match);
			} elseif (in_array($code[$i], self::$skipChars, true)) {	//skip special chars to skip
				continue;
			} elseif (in_array($code[$i], self::$scopeOpenChars, true)) {	//handle scopes
				
				var_dump('scope start at ' . $i);
				
				$scope = new JsScope(substr($code, $i));
				$this->segments[] = $scope;
				
				var_dump('scope end at ' . $scope->getEndOfScope());
				
				$i += $scope->getEndOfScope();
			} elseif (in_array($code[$i], self::$scopeCloseChars, true)) {	//close current scope
				return $i;
			} else {
				$nextTwoChars = substr($code, $i, 2);
				if ($nextTwoChars == '/*') {	//skip comments
					$endOfComment = strpos($code, '*/', $i + 2);
					$i = $endOfComment + 2;
				} elseif ($nextTwoChars == '//') {
					$endOfComment = strpos($code, PHP_EOL, $i + 2);
					$i = $endOfComment + 1;
				} else {
					$nextWord = $this->getNextWord($code, $i);
					
					switch ($nextWord) {	//handle js-keywords
						case 'var':
							$varName = $this->getNextWord($code, $i + 3);
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
