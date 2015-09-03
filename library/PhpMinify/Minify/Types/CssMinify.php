<?php

namespace PhpMinify\Minify\Types;

use PhpMinify\Minify\Types\AbstractMinify;

class CssMinify extends AbstractMinify
{
    public function minify()
    {
        $this->removeNewlines();
        $this->removeMultilineComments();
        $this->removeSpaces();
        
        $this->save();
    }
    
    protected function removeSpaces()
    {
        $content = $this->getFileContent();
        
        $content = preg_replace('/;\s+/', ';', $content);
        $content = preg_replace('/:\s+/', ':', $content);
        $content = preg_replace('/\s+\{\s+/', '{', $content);
        $content = preg_replace('/;*\}/', '}', $content);
        
        $this->setFileContent($content);
    }
}
