<?php
namespace Http\Request\OAuth;

class BearerToken {
  
  public string $accessToken;
  public string $refreshToken;

  public function __construct(string $accessToken, string $refreshToken) {
    $this->accessToken = $accessToken;
    $this->refreshToken = $refreshToken;
  }
}