<?php
namespace HttpRequest;
use HttpRequest\OAuth\BearerToken;

class OAuthMiddleware {
  private static $_instance;
  private mixed $strategy;
  private String $urlRefresh;

  /**
   * @description: Constructor
   * @return: void
   */
  private function __construct(mixed $strategy) {
    $configs = file_get_contents(__DIR__."/../config/http_request.json");
    // $this->configs(json_decode($configs));
    $this->strategy = $strategy;
  }

  /**
   * @description: Singleton
   * @return: self
   */
  public static function getInstance(mixed $strategy) {
    if (!self::$_instance) {
      self::$_instance = new self($strategy);
    }
    return self::$_instance;  
  }

  /**
   * @description: Send request
   * @param: string $method, string $url, array $params
   * @return: self
   */
  public function send(string $method, string $url, array $params, bool $first = true) {
    $response = HttpRequest::getInstance()->$method($url, $params, $this->getHeaders());

    if ($response->status == "200" && $first) {
      $this->send($method, $url, $params, false);
    } 
      
    return $response;
  }

  /**
   * @description: Get the headers
   * @return: array
   */
  private function getHeaders() {
    if($this->strategy instanceof BearerToken){
      return [
        "Authorization:Bearer " . $this->strategy->accessToken
      ];
    } 

    return [];
  }
}