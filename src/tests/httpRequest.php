<?php

namespace HttpRequest\Test;

// spl_autoload_register(function ($class) {
//   require __DIR__."/../". str_replace("\\", "/", $class). ".php";
//   require __DIR__."/../oAuth/". str_replace("\\", "/", $class). ".php";
// });
require __DIR__."/../HttpRequest.php";
require __DIR__."/../OAuthMiddleware.php";
require __DIR__."/../oAuth/StrategyInterface.php";
require __DIR__."/../oAuth/BearerToken.php";
use HttpRequest\HttpRequest;
use HttpRequest\OAuthMiddleware;
use HttpRequest\OAuth\BearerToken;

// $oauth = OAuthMiddleware::getInstance(new BearerToken(
//   "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6I",
//   "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6I")
// )->send("get", "/foo", ["foo" => "bar"]);

// echo (HttpRequest::getInstance() instanceof HttpRequest);

// $res = HttpRequest::getInstance()->get("/");
// // $res = { "status" => 200, "body" => { "id" => 1, "firstname" => "John", "lastName" => "Doe" } }
// print_r($res->data->body->other->foo); // return 200


// print_r(HttpRequest::getInstance()->get("/aaa", []));

// HttpRequest::getInstance()->put("/bbb", []);

// HttpRequest::getInstance()->post("/ccc", []);

?>