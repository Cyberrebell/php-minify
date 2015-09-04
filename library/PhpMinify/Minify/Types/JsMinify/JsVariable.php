<?php

namespace PhpMinify\Minify\Types\JsMinify;

class JsVariable
{
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

    public function __toString()
    {
        if ($this->isDeclaration) {
            return 'var ' . $this->name;
        } else {
            return $this->name;
        }
    }
}
