<?php

namespace app\Controllers;

use framework\Controller;
use app\Models\Person;
use app\Views\DefaultView;
use framework\http\HttpResponse;
use app\Views\ErrorView;
use framework\utils\Router;

class DefaultController extends Controller
{
    public function viewDefault()
    {
        $person = Person::first(1);
        $people = Person::all();

        $framework = "YARAVEL";

        $data = [
            "person" => $person,
            "framework" => $framework,
            "people" => $people
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

    public function addName()
    {
        if (!array_key_exists("visitor", $this->request->post) || !array_key_exists("visitor", $this->request->post)) {
            $error_view = new ErrorView(null, $this->request);

            $error_view->render("renderBadRequest");
            return;
        }

        $visitor = $this->request->post["visitor"];
        $age = $this->request->post["age"];

        if ($visitor === "" || $age === "") {
            $error_view = new ErrorView(null, $this->request);

            $error_view->render("renderBadRequest");
            return;
        }

        $person = new Person();
        $person->name = $visitor;
        $person->age = $age;
        $person->role = "Visitor";

        if ($person->insert() === -1) {
            $error_view = new ErrorView(null, $this->request);

            $error_view->render("renderBadRequest");
            return;
        }

        Router::redirectTo($this->request , "/");
    }
}
