<?php

namespace Test\Request;

require __DIR__.'/../src/httpRequest.php';
use Http\Request\HttpRequest;

$http = HttpRequest::getInstance();

echo $http->get("/");

?>