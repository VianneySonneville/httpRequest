<?php
namespace Http\Request;

class OAuthMiddleware {
  private static $_instance;

  public mixed $strategy;
  public mixed $response;

  /**
   * @description: Constructor
   * @return: void
   */
  public function __construct(mixed $strategy) {
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
  public function send(string $method, string $url, array $params) {
    $this->response = HttpRequest::getInstance()->$method($url, $params, $this->getOpts());

    
    return $this;
  }

  /**
   * @description: Get the headers
   * @return: array
   */
  private function getOpts() {
    if($this->strategy instanceof BearerToken){
      return [
        'headers' => [
          'Authorization' => 'Bearer '. $this->stategy->getAccessToken(),
          'Content-Type' => 'application/json'
        ]
      ];
    } 

    return [];
  }
}