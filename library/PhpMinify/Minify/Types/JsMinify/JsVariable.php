<?php

namespace PhpMinify\Minify\Types\JsMinify;

class JsVariable
{
    public static $jsKeywords = ['null', 'true', 'false', 'break', 'case', 'class', 'catch', 'const', 'continue', 'debugger', 'default', 'delete', 'do', 'else', 'export', 'extends', 'finally', 'for', 'function', 'if', 'import', 'in', 'instanceof', 'let', 'new', 'return', 'super', 'switch', 'this', 'throw', 'try', 'typeof', 'var', 'void', 'while', 'with', 'yield', 'enum', 'await', 'implements', 'package', 'protected', 'static', 'interface', 'private', 'public'];
    protected $length;
    protected $name;
    protected $isDeclaration = false;
    protected $isFunctionCall = false;

    public function __construct($code)
    {
        $this->length = strlen($code);
        for ($i = 0; $i < $this->length; $i++) {
            if ($i == 0 && substr($code, 0, 3) == 'var' && ctype_space($code[3])) {
                $i += 2;
                $this->isDeclaration = true;
            } elseif ($this->name && (ctype_space($code[$i]) || $code[$i] == ';')) {
                $this->length = $i;
                $nextCharPos = $this->getFirstNonSpaceCharPos(substr($code, $i));
                if ($code[$i + $nextCharPos] == '(') {
                    $this->length = $i + $nextCharPos;
                    $this->isFunctionCall = true;
                    break;
                }
            } elseif (ctype_space($code[$i])) {
                continue;
            } elseif ($code[$i] == '/') {
                $comment = new JsComment(substr($code, $i));
                if ($comment->isComment()) {
                    $i += $comment->getLength() - 1;
                }
            } elseif ($code[$i] == '(') {
                $this->length = $i;
                $this->isFunctionCall = true;
                break;
            } else {
                $this->name .= $code[$i];
            }
        }
    }
    
    public function getLength()
    {
        return $this->length;
    }
    
    public function isKeyword()
    {
        if (in_array($this->name, self::$jsKeywords, true)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function isFunctionCall()
    {
        return $this->isFunctionCall;
    }

    public function __toString()
    {
        if ($this->isDeclaration) {
            return 'var ' . $this->name;
        } else {
            return $this->name;
        }
    }
    
    protected function getFirstNonSpaceCharPos($string)
    {
        $length = strlen($string);
        for ($i = 0; $i < $length; $i++) {
            if (!ctype_space($string[$i])) {
                return $i;
            }
        }
    }
}
