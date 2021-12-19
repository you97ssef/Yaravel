<?php

namespace framework;

use framework\http\HttpRequest;

abstract class View
{
    static protected $style_sheets = [];
    static protected $scripts = [];
    static protected $app_title = "Yaravel";

    protected $data = null;

    private $http;

    public function __construct($data, HttpRequest $_http)
    {
        $this->data = $data;
        $this->http = $_http;
    }

    static public function addStyleSheet($path_to_css_files)
    {
        self::$style_sheets[] = $path_to_css_files;
    }

    static public function addScript($path_to_script)
    {
        self::$scripts[] = $path_to_script;
    }

    static public function setAppTitle($title)
    {
        self::$app_title = $title;
    }

    public function render($selector)
    {
        $title = self::$app_title;

        $app_root = $this->http->root;

        $styles = "";

        foreach (self::$style_sheets as $file) {
            $url = $app_root . $file;

            $styles .= <<<HTML
                <link rel="stylesheet" href="$url">
            HTML;
        }

        $scripts = "";

        foreach (self::$scripts as $file) {
            $url = $app_root . $file;

            $scripts .= <<<HTML
                <script src="$url"></script>
            HTML;
        }

        $body = $this->$selector();

        $html = <<<HTML
            <!DOCTYPE html>
            <html lang="fr">
                <head>
                    <meta charset="utf-8">
                    <title>$title</title>
                    $styles
                </head>
                <body>
                    $body
                    $scripts
                </body>
            </html>
        HTML;

        echo $html;
    }
}
