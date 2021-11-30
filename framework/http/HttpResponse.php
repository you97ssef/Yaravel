<?php

namespace framework\http;

class HttpResponse
{
    public static function respond($content, $status = "200 OK")
    {
        header("HTTP/1.1 " . $status);
        echo json_encode($content);
    }
}
