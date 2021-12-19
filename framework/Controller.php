<?php

namespace framework;

use app\Views\ErrorView;
use framework\http\HttpRequest;

abstract class Controller
{
    protected $request = null;

    public function __construct(HttpRequest $_request)
    {
        $this->request = $_request;
    }

    public static function viewNotFound($_request){
        $view = new ErrorView(null, $_request);

        $view->render("renderNotFound");
    }

    public static function viewBadRequest($_request)
    {
        $view = new ErrorView(null, $_request);

        $view->render("renderBadRequest");
    }
}
