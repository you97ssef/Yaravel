<?php

namespace app\Controllers;

use framework\Controller;
use app\Models\Person;
use app\Views\DefaultView;
use framework\http\HttpResponse;

class DefaultController extends Controller
{
    public function viewDefault()
    {
        $person = Person::first(1);

        $framework = "YARAVEL";

        $data = [
            "person" => $person,
            "framework" => $framework
        ];

        $view = new DefaultView($data, $this->request);

        $view::setAppTitle("Welcome to $framework");

        $view->render("renderBody");
    }

    public function get()
    {
        $person = Person::first(1);

        $framework = "YARAVEL";

        $data = [
            "person" => $person->getData(),
            "framework" => $framework
        ];

        HttpResponse::respond($data);
    }
}
