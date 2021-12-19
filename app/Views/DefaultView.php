<?php

namespace app\Views;

use framework\View;

class DefaultView extends View
{
    public function renderBody(): string
    {
        $person = $this->data["person"];
        $framework = $this->data["framework"];

        return <<<HTML
            <main>
                <h1>Hello People and welcome to $framework my Framework.</h1>
                <hr>
                <p>my name is <b>$person->name</b>, i'm <b>$person->age</b> years old. and I'm the <b>$person->role</b> of this Framework</p>
            </main>
        HTML;
    }
}
