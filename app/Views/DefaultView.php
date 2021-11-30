<?php

namespace app\Views;

use framework\View;

class DefaultView extends View
{
    public function renderBody()
    {
        $person = $this->data["person"];
        $framework = $this->data["framework"];

        $html = <<<HTML
            <main>
                <h1>Hello People and welcome to $framework my Framework.</h1>
                <hr>
                <p>my name is <b>$person->name</b>, i'm <b>$person->age</b> years old. and i'm the <b>$person->role</b> of this Framework</p>
            </main>
        HTML;

        return $html;
    }
}
