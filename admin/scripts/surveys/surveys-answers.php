<?php

$query = "SELECT DISTINCT `respondent_id`
          FROM `answers`
          WHERE `survey_id` = " . escape($match['params']['id']);
$result = DB::l()->query($query);

// TODO: think of good way of displaying.

$num_answers = $result->num_rows;

?>

<?php require __DIR__ . "/../../header.php"; ?>

  <div class="content-wrapper">

    <section class="content-header">
      <h1>
        Antwort-Liste
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-lg-6">

          <?php show_flash_message(); ?>

          <?php

          while ($row = $result->fetch_assoc()) {

            $query = "SELECT *
                      FROM `answers`
                      WHERE `respondent_id` = " . escape($row['respondent_id']);
            $result2 = DB::l()->query($query);

            ?>

            <div class="box box-primary">

              <div class="box-header">
                <h3 class="box-title"><?php //ee($row['name']); ?></h3>
              </div>

              <div class="box-body">

                <?php

                while($row2 = $result2->fetch_assoc()) {
                  var_dump($row2);
                }

                 ?>

              </div>

              <div class="box-footer">
<!--                <a href="/admin/survey/--><?php //ee($row['id']); ?><!--/delete" class="btn btn-danger pull-right btn-delete" title="Jetzt beenden">-->
<!--                  <i class="fa fa-fw fa-trash"></i> Löschen-->
<!--                </a>-->
<!--                <a href="/admin/survey/--><?php //ee($row['id']); ?><!--/answers" class="btn btn-primary" title="Jetzt beenden">-->
<!--                  <i class="fa fa-fw fa-list"></i> Liste-->
<!--                </a>-->
<!--                <a href="/admin/survey/--><?php //ee($row['id']); ?><!--/chart" class="btn btn-success" title="Live-Auswertung">-->
<!--                  <i class="fa fa-fw fa-line-chart"></i> Charts-->
<!--                </a>-->
<!--                <a href="/admin/survey/--><?php //ee($row['id']); ?><!--/export" class="btn btn-warning" title="Live-Auswertung">-->
<!--                  <i class="fa fa-fw fa-share-square-o"></i> Export-->
<!--                </a>-->
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