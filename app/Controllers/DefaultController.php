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
        $person = new Person();

        $person->name = "Youssef";
        $person->age = 24;
        $person->role = "Creator";

        $framework = "YARAVEL";

        $data = [
            "person" => $person,
            "framework" => $framework
        ];

        $view = new DefaultView($data, $this->request);

        $view->render("renderBody");
    }

    public function get()
    {
        $person = new Person();

        $person->name = "Youssef";
        $person->age = 24;
        $person->role = "Creator";

        $framework = "YARAVEL";

        $data = [
            "person" => $person->getData(),
            "framework" => $framework
        ];

        return HttpResponse::respond($data);
    }
}
