<?php
namespace Http\Request;

class HttpRequest {
  private static $_instance;
  public string $baseUrl = "";
  public string $port = "";

  public function __construct() {
    try {
      $configs = file_get_contents(__DIR__."/../config/http_request.json");
      $this->configs(json_decode($configs));
    } catch (Exception $e) { echo $e->getMessages(); }
  }

  public static function getInstance() {
    if (!self::$_instance) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }

  /**
   * @description: GET request
   * @param string $url
   * @param array $params
   * @return HTTP-Response body or an empty string if the request fails or is empty
   */
  public function get(string $url, array $params = []) {
      $curl = $this->http_curl_init($url);

      return $this->exec($curl);
  }

  /**
   * @description: POST request
   * @param string $url
   * @param array $params
   * @return HTTP-Response body or an empty string if the request fails or is empty
   */
  public function post(string $url, array $params  = []) {
    $curl = $this->http_curl_init($url, array(
      CURLOPT_POST => true,
      CURLOPT_POSTFIELDS => http_build_query($params)
    ));

    return $this->exec($curl);
  }

  /**
   * @description: PUT request
   * @param string $url
   * @param array $params
   * @return HTTP-Response body or an empty string if the request fails or is empty
   */
  public function put(string $url, array $params  = []) {
    $curl = $this->http_curl_init($url, array(
      CURLOPT_CUSTOMREQUEST => "PUT",
      CURLOPT_POSTFIELDS => http_build_query($params)
    ));

    return this->exec($curl);
  }

  /**
   * @description: DELETE request
   * @param string $url
   * @return HTTP-Response body or an empty string if the request fails or is empty
   */
  public function delete(string $url) {
    $curl = this->http_curl_init($url, array(CURLOPT_CUSTOMREQUEST => "DELETE"));

    return $this->exec($curl);
  }

  /**
   * @description: HTTP-Request initialization
   * @param string $url
   * @param array $opts
   */
  private function http_curl_init(string $url, array $opts = []) {
    $curl = \curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', "Accept:application/json"));
    curl_setopt($curl, CURLOPT_URL, $this->host() . $url);
    
    foreach ($opts as $key => $value) { curl_setopt($curl, $key, $value); }

    return $curl;
  }

  /**
   * @description: Executes the request and returns the response
   * @param CurlHandle|false $url
   * @return HTTP-Response body or an empty string if the request fails or is empty
   */
  private function exec(\CurlHandle|false $curl) {
    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
  }

  private function configs(\stdClass $configs) {
    if (!empty($configs->http_request)) {
      if (!empty($configs->http_request->base_url)) { $this->baseUrl = $configs->http_request->base_url; }
      if (!empty($configs->http_request->port)) { $this->port = $configs->http_request->port; }
    }
  }
  
  private function host() {
    return $this->baseUrl . (empty($this->port) ? "" : ":".$this->port);
  }
}
?>