<?php

namespace app\Views;

use framework\utils\Router;
use framework\View;

class DefaultView extends View
{
    public function renderBody(): string
    {
        $person = $this->data["person"];
        $framework = $this->data["framework"];
        $people = $this->data["people"];

        $people_html = "";
        foreach ($people as $value) {
            $people_html .= <<<HTML
                    <tr>
                        <th scope="row">$value->id</th>
                        <td>$value->name</td>
                        <td>$value->age</td>
                        <td>$value->role</td>
                    </tr>
                HTML;
        }

        $adding_name_route = Router::urlFor($this->http, "/AddName");

        return <<<HTML
            <main class="container">
                <div class="row">
                    <h1>Hello People and welcome to $framework my Framework.</h1>
                    <hr>
                    <div>my name is <a class="link-dark" href="https://youssefb.netlify.app/">$person->name</a>, i'm <b>$person->age</b> years old. and I'm the <b>$person->role</b> of this Framework</div>
                </div>
                <div class="row mt-4 p-2">
                    <div class="row text-center">
                        <h4>Add your name as a visitor</h4>
                    </div>
                    <form action="$adding_name_route" method="post">
                        <div class="mb-2 row">
                            <label for="name" class="col-sm-4 col-form-label">Add your name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="visitor" id="name" placeholder="Enter your name">
                            </div>
                        </div>
                        <div class="mb-2 row">
                            <label for="age" class="col-sm-4 col-form-label">Age</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="age" id="age" placeholder="Enter your age">
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <button type="submit" class="btn btn-dark mx-4 col-4">Add your name</button>
                        </div>
                    </form>
                </div>
                <div class="row p-2">
                    <table class="table table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Age</th>
                                <th scope="col">Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            $people_html
                        </tbody>
                    </table>
                </div>
            </main>
        HTML;
    }
}
