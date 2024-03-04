<?php
namespace HttpRequest;
use HttpRequest\OAuth\BearerToken;
use HttpRequest\OAuth\StrategyInterface;

class OAuthMiddleware {
  private static $_instance;
  private StrategyInterface $strategy;
  private String $urlRefresh;

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
  public static function getInstance(StrategyInterface $strategy) {
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
    $response = HttpRequest::getInstance()->$method($url, $params, $this->getHeadersFromStrategy());

    if ($response->status == "200" && $first) {
      $this->strategy->refreshToken();
      $this->send($method, $url, $params, false);
    } 
      
    return $response;
  }

  /**
   * @description: Get the headers
   * @return: array
   */
  private function getHeadersFromStrategy() {
    return $this->strategy->getHeaders();
  }
}