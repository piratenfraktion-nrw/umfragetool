<?php

$query = "DELETE FROM `questionnaires_questions`
          WHERE `question_id` = " . escape($match['params']['id']) . ";";
DB::l()->query($query);

$result = DB::l()->query($query);

$query = "DELETE FROM `questions`
          WHERE `id` = " . escape($match['params']['id']) . ";";

$result = DB::l()->query($query);
$error = DB::l()->error;

if ($result == true) {
  $_SESSION['flash_status'] = "success";
  $_SESSION['flash_message'] = "Die Frage wurde erfolgreich gelöscht.";
} else if ($error) {
  $_SESSION['flash_status'] = "danger";
  $_SESSION['flash_message'] = "Es ist folgender Fehler aufgetreten: " . $error;
} else {
  $_SESSION['flash_status'] = "danger";
  $_SESSION['flash_message'] = "Es ist ein unbekannter Fehler aufgetreten.";
}

header("Location: /admin/question");
