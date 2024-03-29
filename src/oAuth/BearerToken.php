<?php
namespace HttpRequest\OAuth;

use HttpRequest\oAuth\StrategyInterface;
use HttpRequest\HttpRequest;


class BearerToken implements StrategyInterface {
  private string $refreshToken;
  private string $url;
  public string $accessToken;

  /**
   * @description: Constructor
   * @return void
   */
  public function __construct(string $accessToken, string $refreshToken) {
    $configs = file_get_contents(__DIR__."/../../config/http_request.json");
    $this->configs(json_decode($configs));
    $this->accessToken = $accessToken;
    $this->refreshToken = $refreshToken;
  }

  /**
   * @description: refresh token
   * @return void
   */
  public function refreshToken(): void {
    $response = HttpRequest::getInstance()->post("/".$this->url, [
      "refreshToken" => $this->refreshToken
    ]);

    if ($response->status == 200) {
      $refreshToken = $response->data->refreshToken;
      $refreshToken = $response->data->token;
    }
  }

  /**
   * @description: get headers to set bearer token
   * @return array
   */
  public function getHeaders(): array {
    return [
      "Authorization:Bearer " . $this->accessToken
    ];
  }

  /**
   * @description: configs initialization
   * @param \stdClass $configs
   * @return void
   */
  private function configs(\stdClass $configs): void {
    if (!empty($configs->http_request)) {
      if (
        !empty($configs->http_request->oauth_middleware)
        && !empty($configs->http_request->oauth_middleware->refresh_token)  
      ) {
        $this->url = $configs->http_request->oauth_middleware->refresh_token;
      }
    }
  }
}