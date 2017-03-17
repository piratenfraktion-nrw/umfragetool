<?php

$query = "SELECT *
          FROM `surveys`
          WHERE `id` = " . $match['params']['id'];
$result = DB::l()->query($query);

if ($result->num_rows < 1) {
  echo json_encode(array("status" => "error", "message" => "Umfrage nicht gefunden!"));
  exit;
}

$survey = $result->fetch_assoc();

$questions = array();

$query = "SELECT *
          FROM `questions`
          WHERE `id` IN (
            SELECT DISTINCT `question_id`
            FROM `answers`
            WHERE `survey_id` = " . escape($survey['id']) . "
          )";

$result = DB::l()->query($query);

while ($question = $result->fetch_assoc()) {

  $question['answers'] = json_decode($question['possible_answers'], true);

  // Count number of each answer

  $sum_answers = 0;

  $answers = array();

  // foreach possible answer
  foreach ($question['answers'] as $k => $possible_answer) {

    $query2 = "SELECT COUNT(`answer_text`) AS `c`
               FROM `answers`
               WHERE `survey_id` = " . escape($survey['id']) . "
               AND `question_id` = " . escape($question['id']) . "
               AND `answer_text` = '" . escape($possible_answer) . "'";
    $result2 = DB::l()->query($query2);

    // foreach answer variant
    while ($r = $result2->fetch_assoc()) {
      $answers[] = array(
        "answer_text" => $possible_answer,
        "answer_count" => $r['c']
      );

      $sum_answers += $r['c'];
    }

  }

  //$question['answers'] = $answers;
  $question['labels'] = array_column($answers, 'answer_text');
  $question['counts'] = array_column($answers, 'answer_count');
  unset($question['answers']);
  unset($question['type']);
  unset($question['created_at']);
  unset($question['possible_answers']);
  $question['sum_answers'] = $sum_answers;

  $questions[] = $question;

}

if (isset($_GET['vardump']) && $_GET['vardump'] == 1) {
  var_dump($questions);
} else {
  header("Content-type: application/json; charset=utf-8");
  echo json_encode($questions);
}