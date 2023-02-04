<?php

namespace app\Views;

use framework\View;

class ErrorView extends View
{
    private function renderError(int $code, string $message): string
    {
        return <<<ERROR
            <h1> $code | $message </h1>
        ERROR;
    }

    public function renderNotFound(): string
    {
        return $this->renderError(404, "NOT FOUND");
    }

    public function renderBadRequest(): string
    {
        return $this->renderError(400, "BAD REQUEST");
    }
}
