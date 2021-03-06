<?php

namespace PhpMinify\Minify\Types;

use PhpMinify\Minify\Types\AbstractMinify;
use PhpMinify\Minify\Types\JsMinify\JsScope;

class JsMinify extends AbstractMinify
{
    public function minify()
    {
        $this->parseJsCode();

        $this->save();
    }
    
    protected function parseJsCode()
    {
        $content = $this->getFileContent();

        $jsCode = new JsScope($content);
        
        $this->setFileContent($jsCode);
    }
    
    protected function removeOneLineComments()
    {
        $content = $this->getFileContent();
        
        $content = preg_replace('/\/.+\/(,|;)(*SKIP)(*F)|\'.*\'(*SKIP)(*F)|".*"(*SKIP)(*F)|\/\/.*/', '', $content);
        
        $this->setFileContent($content);
    }
    
    protected function removeSpaces()
    {
        $content = $this->getFileContent();
        
        $regex = '/';
        $regex .= 'var\s(*SKIP)(*F)|';
        $regex .= 'new\s(*SKIP)(*F)|';
        $regex .= 'throw\s(*SKIP)(*F)|';
        $regex .= 'function\s(*SKIP)(*F)|';
        $regex .= 'return\s(*SKIP)(*F)|';
        $regex .= '\sinstanceof\s\w(*SKIP)(*F)|';
        $regex .= 'typeof\s\w(*SKIP)(*F)|';
        $regex .= 'else\sif(*SKIP)(*F)|';
        $regex .= '\sin\s(*SKIP)(*F)|';
        $regex .= '\'.*\'(*SKIP)(*F)|".*"(*SKIP)(*F)|\s/';
        
        $content = preg_replace($regex, '', $content);
        
        $this->setFileContent($content);
    }
}
