<?php

session_start();

require "../lib/altorouter/AltoRouter.php";
require __DIR__ . "/../classes/DB.class.php";
require __DIR__ . "/../classes/functions.php";

$router = new AltoRouter();

$router->setBasePath('/admin');

$router->map('GET', '/', 'index', 'index');

$router->map('GET', '/question', 'question/question-list', 'question-list');
$router->map('GET', '/question/add', 'question/question-add', 'question-add');
$router->map('GET', '/question/[i:id]', 'question/question-single', 'question-single');
$router->map('POST', '/question/[i:id]', 'question/question-edit', 'question-edit');
$router->map('GET', '/question/[i:id]/delete', 'question/question-delete', 'question-delete');

$router->map('GET', '/questionnaire', 'questionnaire/questionnaire-list', 'questionnaire-list');
$router->map('GET', '/questionnaire/add', 'questionnaire/questionnaire-add', 'questionnaire-add');
$router->map('GET', '/questionnaire/[i:id]', 'questionnaire/questionnaire-single', 'questionnaire-single');
$router->map('POST', '/questionnaire/[i:id]', 'questionnaire/questionnaire-edit', 'questionnaire-edit');
$router->map('GET', '/questionnaire/[i:id]/delete', 'questionnaire/questionnaire-delete', 'questionnaire-delete');

$router->map('GET', '/survey/add', 'survey/survey-add', 'survey-add');
$router->map('POST', '/survey/add', 'survey/survey-start', 'survey-start');
$router->map('GET', '/survey/live', 'survey/survey-live', 'survey-live');
$router->map('GET', '/survey/live/charts', 'survey/survey-live-charts', 'survey-live-charts');
$router->map('GET', '/survey/live/charts/resource', 'survey/survey-live-charts-resource', 'survey-live-charts-resource');
$router->map('GET', '/survey/stop', 'survey/survey-stop', 'survey-stop');

$router->map('GET', '/surveys/stopped', 'surveys/surveys-stopped', 'surveys-stopped');

$router->map('GET', '/survey/[i:id]/delete', 'surveys/surveys-delete', 'surveys-delete');
$router->map('GET', '/survey/[i:id]/answers', 'surveys/surveys-answers', 'surveys-answers');
$router->map('GET', '/survey/[i:id]/chart', 'surveys/surveys-chart', 'surveys-chart');
$router->map('GET', '/survey/[i:id]/chart/resource', 'surveys/surveys-chart-resource', 'surveys-chart-resource');
$router->map('GET', '/survey/[i:id]/export', 'surveys/surveys-export', 'surveys-export');
$router->map('GET', '/survey/[i:id]/export/csv', 'surveys/surveys-export-csv', 'surveys-export-csv');

// match current request
$match = $router->match();

if ($match && !in_array($match['name'], array("survey-live", "survey-live-charts", "survey-live-charts-resource", "survey-stop"))) {

  // Check for active survey -> prohibit.
  $query = "SELECT *
            FROM `surveys`
            WHERE `status` = 'live';";
  $result = DB::l()->query($query);
  if($result->num_rows != 0) {
    require "scripts/prohibited.php";
    die();
  }

}

if ($match) {
  require "scripts/" . $match['target'] . ".php";
} else {
  http_response_code(404);
  require "scripts/404.php";
}