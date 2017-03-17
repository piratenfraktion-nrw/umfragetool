<?php require __DIR__ . "/../../header.php"; ?>

<div class="content-wrapper">

<?php

$query = "SELECT *
          FROM `surveys`
          WHERE `status` = 'live'";
$result = DB::l()->query($query);

if ($result->num_rows > 0) {

  ?>

  <section class="content-header">
    <h1>
      Es ist bereits eine Umfrage aktiv.
    </h1>

    <p>Bitte beenden Sie die laufende Umfrage, um eine neue zu starten.</p>

    <a href="/admin/survey/live" class="btn btn-lg btn-success">Zur Umfrage &raquo;</a>
  </section>
  <section class="content">
  </section>
  </div>

  <?php
  require __DIR__ . "/../footer.php";
  die();
}

?>

  <section class="content-header">
    <h1>
      Neue Umfrage starten
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-lg-6">

        <?php show_flash_message(); ?>

        <form method="post" action="">
          <div class="box box-primary">

            <div class="box-body">

              <div class="form-group">
                <label>Auf welchem Fragebogen soll die Umfrage basieren?</label>
                <select class="form-control" name="questionnaire_id">
                  <option value="0" selected>Bitte wählen...</option>
                  <?php

                  $query = "SELECT *
                            FROM `questionnaires`
                            ORDER BY `created_at` DESC";
                  $result = DB::l()->query($query);

                  while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . e($row['id']) . "'>";
                    ee($row['title'] . " (ID: " . $row['id'] . ")");
                    echo "</option>";
                  }

                  ?>
                </select>
              </div>

            </div>
            <div class="box-footer text-right">
              <button type="submit" class="btn btn-success" title="Jetzt starten">
                Jetzt starten <i class="fa fa-fw fa-play"></i>
              </button>
            </div>
          </div>
        </form>

      </div>
    </div>
  </section>

  </div>

<?php ob_start(); ?>
  <script type="text/javascript">

  </script>
<?php $meta['javascript'] = ob_get_clean(); ?>

<?php require __DIR__ . "/../../footer.php"; ?>