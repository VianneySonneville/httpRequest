<?php

// namespace Test\Request;

// require __DIR__.'/../src/httpRequest.php';
// use Http\Request\HttpRequest;

// $http = HttpRequest::getInstance();

// echo $http->get("https://hypnosheaven.ovh/users/categories.json");


$contents = file(__DIR__."/../config/http_request.yaml");

$key = [];
$current_tab = 0;
$data=[];
$current_line = "";

foreach($contents as $key => $line) {
  $current_line = explode(' ', str_replace("\n", "",$line));
  echo json_encode($current_line);
  echo "\n\n";
  if (null == $current_line[$current_tab]){ // si la ligne à current_tab est nul on annulle le tab
    echo "yaml file errors fomatted";
  } else { // sinon on ajoute la clés
    if(validKey($current_line[$current_tab])){
      echo "yaml file errors fomatted";
    } else {
      $data[$current_line[$current_tab]] = [];
      if (null == $current_tab[$current_tab + 1]){
        echo "no suite\n";
      } else {
        $current_tab++;
        echo "yes value ok\n";
      }
      echo json_encode($data);
    }
  }

  break;
}

function validKey(string $key){
  return !str_contains($key, ':') && count(explode(':', $key)) > 0;
}


// Astuce =< on recupere les cles avec leurs indexation en fonction du nombre de [""] ex: si ligne = ["", "", ""] => index_range = 3
// on recupere les valeur dans u tableau . tant que index = 3 , on stock
?>