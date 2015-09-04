<?php

namespace PhpMinify\Minify\Types\JsMinify;

class JsComment
{
    protected $length;

    public function __construct($code)
    {
        $this->length = strlen($code);
        for ($i = 1; $i < $this->length; $i++) {
            if ($code[$i] == '/') {
                $nextNewline = strpos($code, "\n");
                $this->length = $nextNewline + 1;
                break;
            } elseif ($code[$i] == '*') {
                $closeSymbol = strpos($code, '*/');
                $this->length = $closeSymbol + 2;
                break;
            }
        }
    }
    
    public function getLength()
    {
        return $this->length;
    }
    
    public function isComment()
    {
        return $this->length > 0;
    }

    public function __toString()
    {
        return '';
    }
}
