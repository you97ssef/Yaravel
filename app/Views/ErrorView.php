<?php

namespace app\Views;

use framework\View;

class ErrorView extends View
{
    private function renderError(int $code, string $message)
    {
        $html = <<<NOTFOUND
            <h1> $code | $message </h1>
        NOTFOUND;

        return $html;
    }

    public function renderNotFound()
    {
        return $this->renderError(404, "NOT FOUND");
    }

    public function renderBadRequest()
    {
        return $this->renderError(400, "BAD REQUEST");
    }
}
