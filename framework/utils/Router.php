<?php

namespace framework\utils;

use Exception;
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

        try {
            if (array_key_exists($path, $this::$api_routes)) {
                $controller = new $this::$api_routes[$path]["controller"]($this->request);

                if (!isset($this::$api_routes[$path]["methode"]))
                    $methode = strtolower($this->request->method);
                else
                    $methode = $this::$api_routes[$path]["methode"];

                echo $controller->$methode();
            } else {
                echo HttpResponse::respond(["Error" => "NOT FOUND"], Status::$NOT_FOUND);
            }
        } catch (\Exception $exception) {
            echo HttpResponse::respond(["Error" => "BAD REQUEST"], Status::$BAD_REQUEST);
        }
    }

    private function runView($path)
    {
        try {
            if (array_key_exists($path, $this::$routes)) {
                $controller = new $this::$routes[$path]["controller"]($this->request);
                $methode = $this::$routes[$path]["methode"];
                $controller->$methode();
            } else {
                Controller::viewNotFound($this->request);
            }
        } catch (\Exception $exception) {
            Controller::viewBadRequest($this->request);
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

    public function urlFor($route_name = null, $param_list = [])
    {
        $url = $this->request->host_name;

        $url .= $this->request->script_name . $route_name;

        $url .= "?" . http_build_query($param_list);

        return $url;
    }

    public function addRoute($url, $controller, $methode, $access_lvl = -1)
    {
        $this::$routes[$url] = [
            "controller" => $controller,
            "methode" => $methode,
            "access_level" => $access_lvl
        ];
    }

    public function api($url, $controller, $methode = null, $access_lvl = -1)
    {
        $this::$api_routes[$url] = [
            "controller" => $controller,
            "methode" => $methode,
            "access_level" => $access_lvl
        ];
    }
}
