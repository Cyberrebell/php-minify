<?php

namespace PhpMinify\Minify\Types\JsMinify;

class JsScope
{
    public static $jsNoSpaceBehindChars = [';', ')', '}', '=', '>', '<'];
    protected $length;
    protected $segments = [];

    public function __construct($code)
    {
        $this->parseCode($code);
    }
    
    public function getLength()
    {
        return $this->length;
    }

    public function __toString()
    {
        $string = '';
        foreach ($this->segments as $segment) {
            $string .= $segment;
        }
        return $string;
    }
    
    protected function parseCode($code)
    {
        $this->length = strlen($code);
        for ($i = 0; $i < $this->length; $i++) {
            switch ($code[$i]) {
                case '{':
                    //handle sub-scopes
                    $this->segments[] = '{';
                    $subScope = new JsScope(substr($code, $i + 1));
                    $this->segments[] = $subScope;
                    $i += $subScope->getLength() + 1;
                    $this->segments[] = '}';
                    break;
                case '}':
                    $this->length = $i;
                    break;
                case '(':
                    $this->segments[] = '(';
                    $subScope = new JsScope(substr($code, $i + 1));
                    $this->segments[] = $subScope;
                    $i += $subScope->getLength() + 1;
                    $this->segments[] = ')';
                    break;
                case ')':
                    $this->length = $i;
                    break;
                case "'":
                    //handle strings
                    $string = new JsString(substr($code, $i), "'");
                    $this->segments[] = $string;
                    $i += $string->getLength() - 1;
                    break;
                case '"':
                    $string = new JsString(substr($code, $i), '"');
                    $this->segments[] = $string;
                    $i += $string->getLength() - 1;
                    break;
                case '/':
                    //handle comments
                    if ($code[$i + 1] == '/') {
                        $nextNewline = strpos($code, "\n", $i);
                        $i = $nextNewline;
                        break;
                    } elseif ($code[$i + 1] == '*') {
                        $closeSymbol = strpos($code, '*/', $i) + 1;
                        $i = $closeSymbol;
                        break;
                    }
                    // no break
                case 'f':
                    if (substr($code, $i, 3) == 'for' && (ctype_space($code[3]) || $code[3] == '(')) {
                        $conditionStart = strpos($code, '(', $i + 3);
                        $i = $conditionStart - 1;
                        $this->segments[] = 'for';
                        break;
                    }
                    // no break
                case 'i':
                    if (substr($code, $i, 2) == 'if' && (ctype_space($code[2]) || $code[2] == '(')) {
                        $conditionStart = strpos($code, '(', $i + 2);
                        $i = $conditionStart - 1;
                        $this->segments[] = 'if';
                        break;
                    }
                    // no break
                case 'v':
                    if (substr($code, $i, 3) == 'var' && ctype_space($code[3])) {
                        $lastChar = end($this->segments);
                        if (!$lastChar || $lastChar == ';' || ctype_space($lastChar)) {
                            $variable = new JsVariable(substr($code, $i));
                            $this->segments[] = $variable;
                            $i += $variable->getLength() - 1;
                            break;
                        }
                    }
                    // no break
                case 'w':
                    if (substr($code, $i, 5) == 'while' && (ctype_space($code[5]) || $code[5] == '(')) {
                        $conditionStart = strpos($code, '(', $i + 5);
                        $i = $conditionStart - 1;
                        $this->segments[] = 'while';
                        break;
                    }
                    // no break
                default:
                    if (ctype_space($code[$i])) {   //avoid pointless whitespaces
                        $lastChar = end($this->segments);
                        if (is_string($lastChar) && !ctype_space($lastChar) && !in_array($lastChar, self::$jsNoSpaceBehindChars, true)) {
                            $this->segments[] = ' ';
                        }
                    } else {
                        $this->segments[] = $code[$i];
                    }
                    break;
            }
        }
    }
}
