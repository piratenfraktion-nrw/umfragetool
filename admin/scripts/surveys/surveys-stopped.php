<?php

$query = "SELECT *
          FROM `surveys`
          WHERE `status` = 'stopped'
          ORDER BY `date` DESC";
$result = DB::l()->query($query);

$num_surveys = $result->num_rows;

?>

<?php require __DIR__ . "/../../header.php"; ?>


  <div class="content-wrapper">

    <section class="content-header">
      <h1>
        Beendete Umfragen: <?php ee($num_surveys); ?>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-lg-6">

          <?php show_flash_message(); ?>

          <?php

          while ($row = $result->fetch_assoc()) {

            $query = "SELECT COUNT(DISTINCT `respondent_id`), COUNT(DISTINCT `question_id`)
                      FROM `answers`
                      WHERE `survey_id` = " . escape($row['id']);
            $result2 = DB::l()->query($query);
            $row2 = $result2->fetch_row();
            $respondent_count = $row2[0];
            $num_questions = $row2[1];

            ?>

            <div class="box box-primary">

              <div class="box-header">
                <h3 class="box-title"><?php ee($row['name']); ?></h3>
              </div>

              <div class="box-body">

                <div class="row">

                  <div class="col-lg-6">
                    <div class="info-box bg-green">
                      <span class="info-box-icon">
                        <i class="fa fa-users"></i>
                      </span>

                      <div class="info-box-content">
                        <span class="info-box-text">Befragte</span>
                        <span class="info-box-number"><?php ee($respondent_count); ?></span>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="info-box bg-aqua">
                      <span class="info-box-icon">
                        <i class="fa fa-question"></i>
                      </span>

                      <div class="info-box-content">
                        <span class="info-box-text">Fragen</span>
                        <span class="info-box-number"><?php ee($num_questions); ?></span>
                      </div>
                    </div>
                  </div>

                </div>

              </div>

              <div class="box-footer">
                <a href="/admin/survey/<?php ee($row['id']); ?>/delete" class="btn btn-danger pull-right btn-delete" title="Jetzt beenden">
                  <i class="fa fa-fw fa-trash"></i> Löschen
                </a>
<!--                <a href="/admin/survey/--><?php //ee($row['id']); ?><!--/answers" class="btn btn-primary" title="Jetzt beenden">-->
<!--                  <i class="fa fa-fw fa-list"></i> Liste-->
<!--                </a>-->
                <a href="/admin/survey/<?php ee($row['id']); ?>/chart" class="btn btn-success" title="Grafische Auswertung">
                  <i class="fa fa-fw fa-line-chart"></i> Charts
                </a>
                <a href="/admin/survey/<?php ee($row['id']); ?>/export" class="btn btn-warning" title="Live-Auswertung">
                  <i class="fa fa-fw fa-share-square-o"></i> Export
                </a>
              </div>
            </div>

          <?php } ?>

        </div>
      </div>
    </section>

  </div>

<?php ob_start(); ?>
  <script type="text/javascript">

    $("body").on("click", ".btn-delete", function () {
      return confirm("Umfrage wirklich endgültig löschen? Alle Daten gehen unwiderruflich verloren.");
    });

  </script>
<?php $meta['javascript'] = ob_get_clean(); ?>

<?php require __DIR__ . "/../../footer.php"; ?>