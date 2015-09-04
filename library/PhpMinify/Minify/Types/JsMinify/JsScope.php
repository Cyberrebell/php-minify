<?php

namespace PhpMinify\Minify\Types\JsMinify;

class JsScope
{
    public static $jsNoSpaceBehindChars = [';', ')', '}', ',', '=', '>', '<', '+', '-', '*', '%', '&'];
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
                    $this->removeLastSemicolon();
                    $this->removeLastSpace();
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
                    $this->removeLastSpace();
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
                    $comment = new JsComment(substr($code, $i));
                    if ($comment->isComment()) {
                        $i += $comment->getLength() - 1;
                        break;
                    }
                    // no break
                case 'f':
                    if (substr($code, $i, 3) == 'for' && (ctype_space($code[3]) || $code[3] == '(')) {
                        $conditionStart = strpos($code, '(', $i + 3);
                        $i = $conditionStart - 1;
                        $this->segments[] = 'for';
                        break;
                    } elseif (substr($code, $i, 8) == 'function' && (ctype_space($code[8]) || $code[8] == '(')) {
                        $function = new JsFunction(substr($code, $i));
                        $this->segments[] = $function;
                        $i += $function->getLength() - 1;
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
                        $lastChar = end($this->segments);
                        if (!$lastChar || $lastChar == ';') {
                            $variable = new JsVariable(substr($code, $i));
                            if ($variable->isKeyword()) {
                                $this->segments[] = $variable->__toString() . ' ';
                                $i += $variable->getLength();
                            } else {
                                $this->segments[] = $variable;
                                $i += $variable->getLength() - 1;
                            }
                        } else {
                            $this->segments[] = $code[$i];
                        }
                    }
                    break;
            }
        }
    }
    
    protected function removeLastSemicolon()
    {
        if (end($this->segments) == ';') {
            unset($this->segments[key($this->segments)]);
        }
    }
    
    protected function removeLastSpace()
    {
        if (ctype_space(end($this->segments))) {
            unset($this->segments[key($this->segments)]);
        }
    }
}
