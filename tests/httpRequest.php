<?php

namespace Test\Request;

require __DIR__.'/../src/httpRequest.php';
use Http\Request\HttpRequest;

$res = HttpRequest::getInstance()->get("/");
// $res = { "status" => 200, "body" => { "id" => 1, "firstname" => "John", "lastName" => "Doe" } }
echo $res->status; // return 200
?>