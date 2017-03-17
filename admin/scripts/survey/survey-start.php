<?php

$query = "SELECT *
          FROM `surveys`
          WHERE `status` = 'live'";
$result = DB::l()->query($query);

if ($result->num_rows > 0) {
  die("Umfrage läuft.");
}

$valid = true;

if (!isset($_POST['questionnaire_id']))
  $valid &= false;

if (!is_numeric($_POST['questionnaire_id']) || $_POST['questionnaire_id'] < 1)
  $valid &= false;

if ($valid) {

  $query = "SELECT *
            FROM `questionnaires`
            WHERE `id` = " . escape($_POST['questionnaire_id']);
  $result = DB::l()->query($query);
  $row = $result->fetch_assoc();

  $random_name = generateRandomString();

  $query = "INSERT INTO `surveys`
              (`token`, `name`, `questionnaire_id`, `status`)
            VALUES
              ('$random_name', '" . escape($row['title']) . " vom " . date("d.m.Y") . "', " . escape($_POST['questionnaire_id']) . ", 'live');";

  $result = DB::l()->query($query);
  $insert_id = DB::l()->insert_id;

} else {

  $_SESSION['flash_status'] = "danger";
  $_SESSION['flash_message'] = "Bitte wählen Sie eine Umfrage aus.";
  header("Location: /admin/survey/add");
  exit;

}

header("Location: /admin/survey/live");
