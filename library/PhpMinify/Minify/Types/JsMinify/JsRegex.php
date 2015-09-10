<?php

namespace PhpMinify\Minify\Types\JsMinify;

class JsRegex
{
    protected static $jsCharBehindRegex = [',', ';', ')', '}', ']'];
    protected $length;
    protected $string;

    public function __construct($code)
    {
        $this->length = strlen($code);
        $closingDelimiterFound = false;
        for ($i = 1; $i < $this->length; $i++) {
            if (!$closingDelimiterFound && $code[$i] == '/') {
                for ($b = $i - 1; $b > 0; $b--) {
                    if ($code[$b] != '\\') {
                        break;
                    }
                }
                $b++;
                if (($i - $b) % 2 == 0) {
                    $closingDelimiterFound = true;
                }
            } elseif ($closingDelimiterFound && (ctype_space($code[$i]) || in_array($code[$i], self::$jsCharBehindRegex, true))) {
                $this->length = $i;
                $this->string = substr($code, 0, $this->length);
                break;
            }
        }
    }
    
    public function getLength()
    {
        return $this->length;
    }
    
    public function __toString()
    {
        return $this->string;
    }
}
