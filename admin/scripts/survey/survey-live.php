<?php

$query = "SELECT *
          FROM `surveys`
          WHERE `status` = 'live'";
$result = DB::l()->query($query);

if($result->num_rows < 1) {
  header("Location: /admin/survey/add");
  exit;
}

$row = $result->fetch_assoc();

?>

<?php require __DIR__ . "/../../header.php"; ?>


  <div class="content-wrapper">

    <section class="content-header">
      <h1>
        LIVE: <?php ee($row['name']); ?>
      </h1>

      <p>
        Gestartet am <?php ee(date_format(date_create(e($row['date'])), "d.m.Y \u\m H:i:s")); ?>
      </p>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-lg-6">

          <?php show_flash_message(); ?>

          <?php

          $link = "http://" . e($_SERVER['HTTP_HOST']) . "/f/" . e($row['token']);

          ?>

          <div class="box box-primary">

            <div class="box-body">

              <div style="font-size: 2em;">
                Link für die Smartphones der Befrager:<br>
                <a target="_blank" href="<?php echo $link; ?>"><?php echo $link; ?></a>
              </div>

            </div>

            <div class="box-footer">
              <a href="/admin/survey/stop" class="btn btn-danger pull-right" title="Jetzt beenden">
                <i class="fa fa-fw fa-stop"></i> Umfrage beenden
              </a>
              <a href="/admin/survey/live/charts" class="btn btn-success" title="Live-Auswertung">
                <i class="fa fa-fw fa-line-chart"></i> Zur Live-Auswertung
              </a>
            </div>
          </div>

        </div>
      </div>
    </section>

  </div>

<?php ob_start(); ?>
  <script type="text/javascript">

  </script>
<?php $meta['javascript'] = ob_get_clean(); ?>

<?php require __DIR__ . "/../../footer.php"; ?>