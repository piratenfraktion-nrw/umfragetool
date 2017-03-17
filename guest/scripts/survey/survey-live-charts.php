<?php

$query = "SELECT *
          FROM `surveys`
          WHERE `status` = 'live'";
$result = DB::l()->query($query);

if ($result->num_rows < 1) {
  echo "Zur Zeit ist keine Umfrage aktiv.";
  exit;
}

$survey = $result->fetch_assoc();

require __DIR__ . "/../../header.php";

?>

  <div class="content-wrapper" ng-app="UmfragetoolLive" ng-controller="PieCtrl">

    <section class="content-header">

      <button class="pull-right btn btn-default" type="button" colorpicker colorpicker-position="left" ng-model="chart.color">Farbwahl</button>

      <h1>
        LIVE: <?php ee($survey['name']); ?>
      </h1>

      <p>
        Gestartet am <?php ee(date_format(date_create(e($survey['date'])), "d.m.Y \u\m H:i:s")); ?>
      </p>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-lg-6">

          <?php show_flash_message(); ?>

        </div>
      </div>

      <div class="row">

        <div class="col-lg-4 col-md-6" ng-repeat="question in dataSet track by question.id">

          <div class="box">
            <div class="box-header">
              <h6 class="box-title">{{ question.question_text }}</h6>
            </div>
            <div class="box-body">
              <canvas
                class="chart chart-bar"
                chart-data="[question.counts]"
                chart-labels="question.labels"
                chart-series="[question.question_text]"
                chart-legend="false"
                chart-colours="[{fillColor: chart.color}]"
                chart-options="{animationEasing: 'easeInOutCubic', barShowStroke: false}">
              </canvas>
            </div>
          </div>

        </div>

        <div class="col-lg-4" ng-hide="dataSet.length">

          <h4 style="text-decoration: blink;">Warte auf Ergebnisse...</h4>

        </div>

      </div>
    </section>

  </div>

<?php ob_start(); ?>
  <script type="text/javascript">

    var doNotUpdate = false;

  </script>
<?php $meta['javascript'] = ob_get_clean(); ?>

<?php require __DIR__ . "/../../footer.php"; ?>