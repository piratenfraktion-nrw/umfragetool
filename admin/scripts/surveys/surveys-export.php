<?php

error_reporting(0);

$query = "SELECT *
          FROM `surveys`
          WHERE `id` = " . $match['params']['id'];
$survey = DB::l()->query($query);
$survey = $survey->fetch_assoc();

$query = "SELECT MAX(`question_id`)
          FROM `answers`
          WHERE `survey_id` = " . $match['params']['id'];
$result = DB::l()->query($query);

$max_question_id = $result->fetch_row()[0];

$query = "SELECT *
          FROM `answers`
          WHERE `survey_id` = " . $match['params']['id'] . "
          ORDER BY `respondent_id`";
$result = DB::l()->query($query);

?>

<?php require __DIR__ . "/../../header.php"; ?>

  <div class="content-wrapper">

    <section class="content-header">
      <h1>
        Export: <?php ee($survey['name']); ?>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-lg-12">

          <?php show_flash_message(); ?>

          <p>
            Hier die <a href="export/csv" target="_blank">CSV-Datei herunterladen</a>
          </p>

          <p></p>

          <div>
            Hier die CSV-Daten zum Kopieren &amp; Einfügen:<br>
            <textarea class="form-control" style="min-height: 800px;"><?php

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

            ?></textarea>
          </div>


        </div>
      </div>
    </section>

  </div>

<?php require __DIR__ . "/../../footer.php"; ?>