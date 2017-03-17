<?php

error_reporting(0);
ini_set("log_errors", 0);

session_start();

require "../lib/altorouter/AltoRouter.php";
require __DIR__ . "/../classes/DB.class.php";
require __DIR__ . "/../classes/functions.php";

$router = new AltoRouter();

$router->setBasePath('/f');

$router->map('GET', '/', 'index', 'index');

$router->map('GET', '/[i:survey_id]', 'survey', 'survey');
$router->map('POST', '/[i:survey_id]', 'save-answer', 'save-answer');

// match current request
$match = $router->match();

if ($match && $match['name'] == "survey") {

  // Check for active survey -> prohibit if none found
  $query = "SELECT *
            FROM `surveys`
            WHERE `status` = 'live'
            AND `token` = " . escape($match['params']['survey_id']);
  $result = DB::l()->query($query);

  if ($result->num_rows < 1) {
    http_response_code(404);
    require "scripts/prohibited.php";
    die();
  }

}

if($match) {
  require "scripts/" . $match['target'] . ".php";
} else {
  http_response_code(404);
  require "scripts/404.php";
}