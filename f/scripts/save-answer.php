<?php

header("Content-type: application/json; charset=UTF-8");

$input = json_decode(file_get_contents("php://input"), true);

// Check, ob Umfrage existiert und live ist.

$query = "SELECT *
          FROM `surveys`
          WHERE `status` = 'live'
          AND `id` = " . escape($input['survey_id']);
$result = DB::l()->query($query);

if ($result->num_rows < 1)
  exit_with_error_json("Diese Umfrage existiert nicht oder wurde beendet.");

$survey = $result->fetch_assoc();

// Check, ob alle Fragen beantwortet wurden.
// TODO: Check, ob die Antworten in den erlaubten Möglichkeiten sind!

$query = "SELECT *
          FROM `questionnaires_questions`
          WHERE `questionnaire_id` = " . escape($survey['questionnaire_id']);
$result = DB::l()->query($query);
$num_questions = $result->num_rows;

if (isset($input['answers']) && is_array($input['answers']) && count($input['answers']) == $num_questions) {
  // Alles gut.
} else {
  exit_with_error_json("Es wurden nicht alle Fragen beantwortet");
}

// Den Befragten anlegen

$query = "INSERT INTO `respondents` (`survey_id`) VALUES (" . escape($input['survey_id']) . ")";
DB::l()->query($query);
$insert_id = DB::l()->insert_id;
$json['respondent_id'] = $insert_id;

// Antworten in die Datenbank schreiben

foreach ($input['answers'] as $k => $answer) {

  $question_id = substr($k, 9); // extrahiert 5 aus 'question_5'

  $query = "INSERT INTO `answers` (
              `tablet_id`,
              `survey_id`,
              `respondent_id`,
              `question_id`,
              `question_text`,
              `answer_text`
              )
            VALUES (
              " . escape($_COOKIE['TABLET_ID']) . ",
              " . escape($survey['id']) . ",
              " . escape($insert_id) . ",
              " . escape($question_id) . ",
                (SELECT `question_text`
                FROM `questions`
                WHERE `id` = " . escape($question_id) . "),
              '" . escape($answer) . "'
            )";
  $result = DB::l()->query($query);
  if (DB::l()->error)
    $json['sql_error'] = DB::l()->error;
}

// Anzahl der bisher befragten berechnen:

$query = "SELECT COUNT(DISTINCT `respondent_id`)
          FROM `answers`
          WHERE `survey_id` = " . escape($survey['id']);
$result = DB::l()->query($query);
$sum_respondents = $result->fetch_row();
$json['sum_respondents'] = $sum_respondents[0];


$json['status'] = "success";

echo json_encode($json);
