<?php

namespace PhpMinify\Minify\Types\JsMinify;

class JsScope extends JsCode
{
	protected $scopeOpenChar;
	protected $scopeCloseChar;
	protected $endOfScope = 0;
	
	function __construct($code) {
		$this->scopeOpenChar = $code[0];
		$this->scopeCloseChar = $this->getMatchingCloseChar($this->scopeOpenChar);
		
		var_dump($this->scopeOpenChar . $this->scopeCloseChar);
		
		$this->segments[] = $this->scopeOpenChar;
		$this->endOfScope = $this->resolveCodeToSegments(substr($code, 1));
		$this->segments[] = $this->scopeCloseChar;
		$this->segments[] = ';';
	}
	
	
	
	function getEndOfScope() {
		return $this->endOfScope;
	}
	
	protected function getMatchingCloseChar($openChar) {
		if ($openChar == '(') {
			return ')';
		} elseif ($openChar == '{') {
			return '}';
		} else {
			throw new \Exception('Used JsScope-Class with the Character "' . $this->scopeOpenChar . '" which is not a scope limiter!');
		}
	}
}
