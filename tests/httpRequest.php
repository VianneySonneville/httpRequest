<?php

namespace Test\Request;

require __DIR__.'/../src/httpRequest.php';
require __DIR__.'/../src/oAuthMiddleware.php';
require __DIR__.'/../src/oAuth/bearerToken.php';
use Http\Request\HttpRequest;
use Http\Request\OAuthMiddleware;
use Http\Request\OAuth\BearerToken;

$oauth = OAuthMiddleware::getInstance(new BearerToken(
  "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6I",
  "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6I")
)->send("get", "/", ["foo" => "bar"]);

print_r($oauth);

// echo (HttpRequest::getInstance() instanceof HttpRequest);

// $res = HttpRequest::getInstance()->get("/");
// // $res = { "status" => 200, "body" => { "id" => 1, "firstname" => "John", "lastName" => "Doe" } }
// echo $res->status; // return 200


// print_r(HttpRequest::getInstance()->get("/aaa", []));

// HttpRequest::getInstance()->put("/bbb", []);

// HttpRequest::getInstance()->post("/ccc", []);

?>