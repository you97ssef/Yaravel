<?php

namespace framework\http;

class HttpRequest
{
    public $script_name = null;
    public $path_info = null;
    public $root = null;
    public $method = null;
    public $get = null;
    public $post = null;
    
    public $host_name = null;

    function __construct()
    {
        $this->script_name = $_SERVER["SCRIPT_NAME"];
        if (isset($_SERVER["PATH_INFO"]))
            $this->path_info = $_SERVER["PATH_INFO"];
        $this->root = dirname($_SERVER["SCRIPT_NAME"]);
        $this->method = $_SERVER["REQUEST_METHOD"];
        $this->get = $_GET;
        $this->post = $_POST;

        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $this->host_name = "https://";
        else
            $this->host_name = "http://"; 
        $this->host_name .= $_SERVER['HTTP_HOST']; 
    }
}
