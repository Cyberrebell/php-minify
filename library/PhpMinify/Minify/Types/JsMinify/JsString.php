<?php

namespace PhpMinify\Minify\Types\JsMinify;

class JsString
{
    protected $length;
    protected $string = '';

    public function __construct($code, $separator)
    {
        $this->string = $separator;
        $this->length = strlen($code);
        for ($i = 1; $i < $this->length; $i++) {
            $this->string .= $code[$i];
            if ($code[$i] == $separator) {
                for ($b = $i - 1; $b > 0; $b--) {
                    if ($code[$b] != '\\') {
                        break;
                    }
                }
                $b++;
                if (($i - $b) % 2 == 0) {
                    $this->length = $i + 1;
                }
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
