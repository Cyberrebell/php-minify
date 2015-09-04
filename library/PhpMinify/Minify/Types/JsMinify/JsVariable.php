<?php

namespace PhpMinify\Minify\Types\JsMinify;

class JsVariable
{
    public static $jsKeywords = ['null', 'true', 'false', 'break', 'case', 'class', 'catch', 'const', 'continue', 'debugger', 'default', 'delete', 'do', 'else', 'export', 'extends', 'finally', 'for', 'function', 'if', 'import', 'in', 'instanceof', 'let', 'new', 'return', 'super', 'switch', 'this', 'throw', 'try', 'typeof', 'var', 'void', 'while', 'with', 'yield', 'enum', 'await', 'implements', 'package', 'protected', 'static', 'interface', 'private', 'public'];
    protected $length;
    protected $name;
    protected $isDeclaration = false;

    public function __construct($code)
    {
        $this->length = strlen($code);
        for ($i = 0; $i < $this->length; $i++) {
            if ($i == 0 && substr($code, 0, 3) == 'var' && ctype_space($code[3])) {
                $i += 2;
                $this->isDeclaration = true;
            } elseif ($this->name && (ctype_space($code[$i]) || $code[$i] == ';')) {
                $this->length = $i;
            } elseif (ctype_space($code[$i])) {
                continue;
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

    public function __toString()
    {
        if ($this->isDeclaration) {
            return 'var ' . $this->name;
        } else {
            return $this->name;
        }
    }
}
