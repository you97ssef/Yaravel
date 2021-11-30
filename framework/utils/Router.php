<?php

namespace framework\utils;

use framework\Controller;
use framework\http\HttpRequest;
use framework\http\HttpResponse;
use framework\http\Status;

class Router
{
    public static $routes = array();
    public static $api_routes = array();
    protected $request = null;

    public function __construct(HttpRequest $_request)
    {
        $this->request = $_request;
    }

    private function runAPI($path)
    {
        //API Settings
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        if (array_key_exists($path, $this::$api_routes)) {
            $controller = new $this::$api_routes[$path][0]($this->request);

            if (!isset($this::$api_routes[$path][1]))
                $methode = strtolower($this->request->method);
            else
                $methode = $this::$api_routes[$path][1];

            echo $controller->$methode();
        } else {
            echo HttpResponse::respond(["Error" => "NOT FOUND"], Status::$NOT_FOUND);
        }
    }

    private function runView($path)
    {
        if (array_key_exists($path, $this::$routes)) {
            $controller = new $this::$routes[$path][0]($this->request);
            $methode = $this::$routes[$path][1];
            $controller->$methode();
        } else {
            Controller::viewNotFound($this->request);
        }
    }

    public function run()
    {
        $currentPath = $this->request->path_info;
        if (substr($currentPath, 0, 4) === "/api") {
            $this->runAPI(substr($currentPath, 4));
        } else {
            $this->runView($currentPath);
        }
    }

    //TODO
    /*
    public function urlFor($route_name, $param_list = [])
    {
        $lien = $this->request->script_name;

        return $lien;
    }
    */

    public function addRoute($url, $controller, $methode, $access_lvl = -1)
    {
        $this::$routes[$url] = [$controller, $methode, $access_lvl];
    }

    public function api($url, $controller, $methode = null, $access_lvl = -1)
    {
        $this::$api_routes[$url] = [$controller, $methode, $access_lvl];
    }
}
