<?php

namespace PhpMinify\Minify\Types\JsMinify;

class JsFunction
{
    protected $length;
    protected $name;
    
    public function __construct($code)
    {
        $this->length = strlen($code);
        for ($i = 0; $i < $this->length; $i++) {
            if ($i == 0 && substr($code, 0, 8) == 'function' && ctype_space($code[8])) {
                $i += 7;
            } elseif ($this->name && (ctype_space($code[$i]) || $code[$i] == '(')) {
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
        return 'function ' . $this->name;
    }
}
