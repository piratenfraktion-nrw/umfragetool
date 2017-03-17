<?php

$valid = true;

if (!isset($_POST['title']))
  $valid &= false;

if (!isset($_POST['description']))
  $valid &= false;

if (!isset($_POST['question_ids']))
  $valid &= false;

if (!is_array($_POST['question_ids']))
  $valid &= false;

if (!isset($_POST['questionnaire_id']))
  $valid &= false;

if (!is_numeric($_POST['questionnaire_id']))
  $valid &= false;

if ($valid) {

  // Remove old questions
  $query = "DELETE FROM `questionnaires_questions`
            WHERE `questionnaire_id` = " . escape($_POST['questionnaire_id']);
  DB::l()->query($query);

  // Insert new questions
  $counter = 0;
  foreach ($_POST['question_ids'] as $q_id) {

    $query = "INSERT INTO `questionnaires_questions`
                (`questionnaire_id`, `question_id`, `position`)
              VALUES
                (" . escape($_POST['questionnaire_id']) . ", " . escape($q_id) . ", " . escape(++$counter) . ")";
    DB::l()->query($query);
  }

  // Change title and description
  $query = "UPDATE `questionnaires`
            SET `title` = '" . escape($_POST['title']) . "', `description` = '" . escape($_POST['description']) . "'
            WHERE `id` = " . escape($_POST['questionnaire_id']);
  DB::l()->query($query);

  $result = true;

} else {
  $result = false;
  $error = "Erforderliche Felder nicht übermittelt.";
}

if ($result == true) {
  $_SESSION['flash_status'] = "success";
  $_SESSION['flash_message'] = "Der Fragebogen wurde erfolgreich geändert.";
} else if ($error) {
  $_SESSION['flash_status'] = "danger";
  $_SESSION['flash_message'] = "Es ist folgender Fehler aufgetreten: " . $error;
} else {
  $_SESSION['flash_status'] = "danger";
  $_SESSION['flash_message'] = "Es ist ein unbekannter Fehler aufgetreten.";
}

header("Location: /admin/questionnaire");
