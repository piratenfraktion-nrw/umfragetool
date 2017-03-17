<?php

$valid = true;

if (!isset($_POST['question_text']))
  $valid &= false;

if (!isset($_POST['possible_answers']))
  $valid &= false;

if (!is_array($_POST['possible_answers']))
  $valid &= false;

if (!isset($_POST['question_id']))
  $valid &= false;

if (!is_numeric($_POST['question_id']))
  $valid &= false;

if ($valid) {

  $query = "UPDATE `questions`
          SET `question_text` = '" . escape($_POST['question_text']) . "',
              `possible_answers` = '" . escape(json_encode($_POST['possible_answers'])) . "'
          WHERE `id` = " . escape($_POST['question_id']) . ";";

  $result = DB::l()->query($query);
  $error = DB::l()->error;

} else {
  $result = false;
  $error = "Erforderliche Felder nicht übermittelt.";
}

if ($result == true) {
  $_SESSION['flash_status'] = "success";
  $_SESSION['flash_message'] = "Die Frage wurde erfolgreich geändert.";
} else if ($error) {
  $_SESSION['flash_status'] = "danger";
  $_SESSION['flash_message'] = "Es ist folgender Fehler aufgetreten: " . $error;
} else {
  $_SESSION['flash_status'] = "danger";
  $_SESSION['flash_message'] = "Es ist ein unbekannter Fehler aufgetreten.";
}

header("Location: /admin/question");
