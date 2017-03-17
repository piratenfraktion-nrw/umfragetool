<?php

$query = "SELECT *
          FROM `surveys`
          WHERE `status` = 'live'
          AND `token` = " . escape($match['params']['survey_id']);
$result = DB::l()->query($query);

$survey = $result->fetch_assoc();

$cookie_valid = false;

if(isset($_COOKIE['TABLET_ID']) && isset($_COOKIE['SURVEY_ID']) && $_COOKIE['TABLET_ID'] && $_COOKIE['SURVEY_ID']) {
  if($_COOKIE['SURVEY_ID'] == $survey['id']) {
    $cookie_valid = true;
  }
}

if(!$cookie_valid) {
  // Tablet is new to this survey -> set cookies!
  $new_tablet_id = $survey['max_tablet_id'] + 1;
  $query = "UPDATE `surveys`
            SET `max_tablet_id` = `max_tablet_id` + 1
            WHERE `id` = " . escape($survey['id']);
  DB::l()->query($query);
  setcookie('TABLET_ID', $new_tablet_id);
  setcookie('SURVEY_ID', $survey['id']);
}

require __DIR__ . "/../header.php";

?>

<div class="container">

  <div ng-controller="FragebogenCtrl">

    <h2><?php ee($survey['name']); ?></h2>

    <h3 style="margin-bottom: 20px;">Folgende Fragen sollen beantwortet werden</h3>

    <?php

    $query = "SELECT q.*
              FROM `questions` q, `questionnaires_questions` qq
              WHERE qq.`question_id` = q.`id`
              AND qq.`questionnaire_id` = " . escape($survey['questionnaire_id']) . "
              ORDER BY qq.`position`";
    $result = DB::l()->query($query);

    while ($row = $result->fetch_assoc()) {

      echo "<h4>" . e($row['question_text']) . "</h4>";

      $answers = json_decode($row['possible_answers']);

      echo '<div class="btn-group" data-toggle="buttons">';

      foreach ($answers as $k => $answer) {
        echo "<label class=\"btn btn-default radiolabel\" ng-click=\"answers.question_" . e($row['id']) . " = '" . e(str_replace("'", "\'", $answer)) . "'\">";
        echo '<input type="radio" autocomplete="off"> ' . e($answer) . '</input>';
        echo '</label>';
      }

      echo '</div>';

    }

    ?>

    <input type="hidden" id="survey_id" value="<?php ee($survey['id']); ?>">

    <button
      class="btn btn-block btn-success"
      style="margin: 25px 0;"
      ng-click="submit_answer()"
      ng-disabled="submitting">
      Antworten jetzt absenden
    </button>

  </div>

</div>
<!-- /.container -->


<?php ob_start(); ?>
<script type="text/javascript">

</script>
<?php $meta['javascript'] = ob_get_clean(); ?>

<?php require __DIR__ . "/../footer.php"; ?>
