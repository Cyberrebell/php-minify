<?php

namespace PhpMinify\Minify\Types;

abstract class AbstractMinify
{
    protected $file;
    protected $fileContent;
    
    public function __construct($file)
    {
        $this->file = $file;
    }
    
    abstract public function minify();
    
    public function getFileContent()
    {
        if ($this->fileContent === null) {
            $this->fileContent = file_get_contents($this->file);
        }
        return $this->fileContent;
    }
    
    public function setFileContent($content)
    {
        $this->fileContent = $content;
    }
    
    protected function save()
    {
        file_put_contents($this->file, $this->getFileContent());
    }
    
    protected function removeMultilineComments()
    {
        $content = $this->getFileContent();
        
        $content = preg_replace('/\'.*\'(*SKIP)(*F)|".*"(*SKIP)(*F)|\/\*.*\*\//sU', '', $content);
        
        $this->setFileContent($content);
    }
    
    protected function removeOneLineComments()
    {
        $content = $this->getFileContent();
        
        $content = preg_replace('/\'.*\'(*SKIP)(*F)|".*"(*SKIP)(*F)|\/\/.*/', '', $content);
        
        $this->setFileContent($content);
    }
    
    protected function removeNewlines()
    {
        $content = $this->getFileContent();
        
        $content = str_replace("\n", '', $content);
        
        $this->setFileContent($content);
    }
    
    protected function removeSpaces()
    {
        $content = $this->getFileContent();
        
        $content = preg_replace('/\'.*\'(*SKIP)(*F)|".*"(*SKIP)(*F)|\s/', '', $content);
        
        $this->setFileContent($content);
    }
}
