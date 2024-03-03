<?php
namespace Http\Request;
use Http\Request\OAuth\BearerToken;

class OAuthMiddleware {
  private static $_instance;

  public mixed $strategy;
  public mixed $response;

  /**
   * @description: Constructor
   * @return: void
   */
  private function __construct(mixed $strategy) {
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
    $this->response = HttpRequest::getInstance()->$method($url, $params, $this->getHeaders());

    if $this->response->status == 200 && $first {
      $this->strategy->refresh();
      $this->send($method, $url, $params, false);
    } 
      
    return $this->response;
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