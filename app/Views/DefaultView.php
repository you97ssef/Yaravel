<?php

namespace app\Views;

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

        return <<<HTML
            <main>
                <div class="row p-2">
                    <h1>Hello People and welcome to $framework my Framework.</h1>
                    <hr>
                    <p>my name is <a href="https://youssefb.netlify.app/">$person->name</a>, i'm <b>$person->age</b> years old. and I'm the <b>$person->role</b> of this Framework</p>
                </div>
                <div class="row p-5">
                    <table class="table table-hover table-dark table-bordered">
                        <thead>
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
