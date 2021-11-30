<?php

namespace framework\utils;

class ClassLoader
{
    private $prefix = '';

    public function __construct($file_root)
    {
        $this->prefix = $file_root;
    }

    public function register()
    {
        spl_autoload_register(array($this, 'loadClass'));
    }

    public function loadClass(string $classname)
    {
        $fileName = $this->getFilename($classname);
        $path = $this->makePath($fileName);
        if (file_exists($path)) {
            require_once($path);
        }
    }

    public function getFilename(string $classname): string
    {
        $str = str_replace("\\", '/', $classname) . ".php";
        return $str;
    }

    public function makePath(string $filename): string
    {
        return $this->prefix . DIRECTORY_SEPARATOR . $filename;
    }
}
