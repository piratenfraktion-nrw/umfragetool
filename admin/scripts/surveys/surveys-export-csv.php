<?php

error_reporting(0);

// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=umfrage_export.csv');

$query = "SELECT MAX(`question_id`)
          FROM `answers`
          WHERE `survey_id` = " . $match['params']['id'];
$result = DB::l()->query($query);

$max_question_id = $result->fetch_row()[0];

$query = "SELECT *
          FROM `answers`
          WHERE `survey_id` = " . $match['params']['id'];
$result = DB::l()->query($query);

$out = fopen('php://output', 'w');

$counter = 0;
$header_array = array('tablet_id', 'respondent_id');
for($i = 1; $i <= $max_question_id; $i++) {
  $header_array[] = 'q' . $i;
}
$header_array[] = 'timestamp';

fputs($out, '"' . join('";"', $header_array) . '"' . PHP_EOL);

$previous_row = array();

while ($row = $result->fetch_assoc()) {

  if($previous_row['respondent_id'] != $row['respondent_id']) {

    if($previous_row)
      $row_array[] = $previous_row['created_at'];
    if(isset($row_array))
      fputs($out, '"' . join('";"', $row_array) . '"' . PHP_EOL);

    // New row!
    $row_array = array();
    $row_array[] = $row['tablet_id'];
    $row_array[] = $row['respondent_id'];
  }
  $row_array[] = $row['answer_text'];

  $previous_row = $row;
  $counter++;
}

$row_array[] = $previous_row['created_at'];
fputs($out, '"' . join('";"', $row_array) . '"');

fclose($out);