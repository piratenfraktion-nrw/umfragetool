<?php

// Delete 1. answers

$query = "DELETE FROM `answers`
          WHERE `survey_id` = " . escape($match['params']['id']);
$result = DB::l()->query($query);

// Delete 2. respondent

$query = "DELETE FROM `respondents`
          WHERE `survey_id` = " . escape($match['params']['id']);
$result = DB::l()->query($query);

// Delete 3. survey

$query = "DELETE FROM `surveys`
          WHERE `id` = " . escape($match['params']['id']);
$result = DB::l()->query($query);

$_SESSION['flash_status'] = "success";
$_SESSION['flash_message'] = "Umfrage wurde unwiderruflich gelöscht.";
header("Location: /admin/surveys/stopped");
exit;