<?php

$query = "SELECT *
          FROM `surveys`
          WHERE `id` = " . $match['params']['id'];
$survey = DB::l()->query($query);
$survey = $survey->fetch_assoc();

require __DIR__ . "/../../header.php";

?>

  <div class="content-wrapper" ng-app="UmfragetoolLive" ng-controller="PieCtrl">

    <section class="content-header">

      <button class="pull-right btn btn-default" type="button" colorpicker colorpicker-position="left" ng-model="chart.color">Farbwahl</button>

      <h1>
        Charts: <?php ee($survey['name']); ?>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-lg-6">

          <?php show_flash_message(); ?>

        </div>
      </div>

      <div id="ctrl" class="row">

        <div class="col-lg-4" ng-repeat="question in dataSet track by $index">

          <div class="bg-white">

            <h5><b>{{ question.question_text }}</b></h5>

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

        <div class="col-lg-4" ng-hide="dataSet.length">

          <h4 style="text-decoration: blink;">Warte auf Ergebnisse...</h4>

        </div>

      </div>
    </section>

  </div>

<?php ob_start(); ?>
  <script type="text/javascript">

    var doNotUpdate = true;

  </script>
<?php $meta['javascript'] = ob_get_clean(); ?>

<?php require __DIR__ . "/../../footer.php"; ?>