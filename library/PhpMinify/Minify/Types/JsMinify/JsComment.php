<?php

namespace PhpMinify\Minify\Types\JsMinify;

class JsComment
{
    protected $length;

    public function __construct($code)
    {
        $this->length = 0;
        if ($code[1] == '/') {
            $nextNewline = strpos($code, "\n");
            $this->length = $nextNewline + 1;
        } elseif ($code[1] == '*') {
            $closeSymbol = strpos($code, '*/');
            $this->length = $closeSymbol + 2;
        }
    }
    
    public function getLength()
    {
        return $this->length;
    }
    
    public function isComment()
    {
        return ($this->length > 0);
    }

    public function __toString()
    {
        return '';
    }
}
