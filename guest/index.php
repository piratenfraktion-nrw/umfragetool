<?php

session_start();

require "../lib/altorouter/AltoRouter.php";
require __DIR__ . "/../classes/DB.class.php";
require __DIR__ . "/../classes/functions.php";

$router = new AltoRouter();

$router->setBasePath('/guest');

$router->map('GET', '/', 'survey/survey-live-charts', 'survey-live-charts');
$router->map('GET', '/charts/resource', 'survey/survey-live-charts-resource', 'survey-live-charts-resource');

// match current request
$match = $router->match();

if ($match) {
  require "scripts/" . $match['target'] . ".php";
} else {
  http_response_code(404);
  require "scripts/404.php";
}