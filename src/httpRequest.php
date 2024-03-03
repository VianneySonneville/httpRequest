<?php
namespace Http\Request;

class HttpRequest {

  private static $_instance;
  private string $baseUrl = "";
  private string $port = "";

  /**
   * @description: Constructor
   * @return void
   */
  private function __construct() {
    try {
      $configs = file_get_contents(__DIR__."/../config/http_request.json");
      $this->configs(json_decode($configs));
    } catch (Exception $e) { echo $e->getMessages(); }
  }

  /**
   * @description: Singleton
   * @return self
   */
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
   * @param array $headers
   * @return HTTP-Response body or an empty string if the request fails or is empty
   */
  public function get(string $url, array $params = [], array $headers = []) {
      $curl = $this->http_curl_init($url, array(
        CURLOPT_HTTPHEADER => array_merge(array('Content-Type:application/json', "Accept:application/json"), $headers)
      ));

      return $this->exec($curl);
  }

  /**
   * @description: POST request
   * @param string $url
   * @param array $params
   * @param array $headers
   * @return HTTP-Response body or an empty string if the request fails or is empty
   */
  public function post(string $url, array $params  = [], array $headers = []) {
    $curl = $this->http_curl_init($url, array(
      CURLOPT_POST => true,
      CURLOPT_HTTPHEADER => array_merge(array('Content-Type:application/json', "Accept:application/json"), $headers),
      CURLOPT_POSTFIELDS => http_build_query($params)
    ));

    return $this->exec($curl);
  }

  /**
   * @description: PUT request
   * @param string $url
   * @param array $params
   * @param array $headers
   * @return HTTP-Response body or an empty string if the request fails or is empty
   */
  public function put(string $url, array $params  = [], array $headers = []) {
    $curl = $this->http_curl_init($url, array(
      CURLOPT_CUSTOMREQUEST => "PUT",
      CURLOPT_HTTPHEADER => array_merge(array('Content-Type:application/json', "Accept:application/json"), $headers),
      CURLOPT_POSTFIELDS => http_build_query($params)
    ));

    return this->exec($curl);
  }

  /**
   * @description: DELETE request
   * @param string $url
   * @param array $headers
   * @return HTTP-Response body or an empty string if the request fails or is empty
   */
  public function delete(string $url, array $headers = []) {
    $curl = this->http_curl_init($url, array(
      CURLOPT_CUSTOMREQUEST => "DELETE",
      CURLOPT_HTTPHEADER => array_merge(array('Content-Type:application/json', "Accept:application/json"), $headers)
    ));

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
    $satus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    return [
      "status" => $satus,
      "body" => json_decode($response)
    ];
  }

  /**
   * @description: Configs initialization
   * @param \stdClass $configs
   * @return void
   */
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