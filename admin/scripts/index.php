<?php require __DIR__ . "/../header.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Umfragetool Administration
      </h1>
    </section>

    <?php

    $query = "SELECT COUNT(*) FROM `questions`";
    $result = DB::l()->query($query);
    $row = $result->fetch_row();
    $num_questions = $row[0];

    $query = "SELECT COUNT(*) FROM `questionnaires`";
    $result = DB::l()->query($query);
    $row = $result->fetch_row();
    $num_questionnaires = $row[0];

    $query = "SELECT COUNT(*) FROM `surveys`";
    $result = DB::l()->query($query);
    $row = $result->fetch_row();
    $num_surveys = $row[0];

    $query = "SELECT COUNT(*) FROM `respondents`";
    $result = DB::l()->query($query);
    $row = $result->fetch_row();
    $num_respondents = $row[0];

    $query = "SELECT COUNT(*) FROM `answers`";
    $result = DB::l()->query($query);
    $row = $result->fetch_row();
    $num_answers = $row[0];

    ?>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-lg-4">

          <div class="info-box">
            <span class="info-box-icon bg-light-blue">
              <i class="fa fa-question"></i>
            </span>

            <div class="info-box-content">
              <span class="info-box-text">Fragen</span>
              <span class="info-box-number"><?php echo $num_questions; ?></span>
            </div>
          </div>

        </div>

        <div class="col-lg-4">

          <div class="info-box">
            <span class="info-box-icon bg-light-blue">
              <i class="fa fa-list"></i>
            </span>

            <div class="info-box-content">
              <span class="info-box-text">Fragebögen</span>
              <span class="info-box-number"><?php echo $num_questionnaires; ?></span>
            </div>
          </div>

        </div>

      </div>
      <div class="row">

        <div class="col-lg-4">

          <div class="info-box">
          <span class="info-box-icon bg-yellow">
            <i class="fa fa-line-chart"></i>
          </span>

            <div class="info-box-content">
              <span class="info-box-text">Umfragen</span>
              <span class="info-box-number"><?php echo $num_surveys; ?></span>
            </div>
          </div>

        </div>

      </div>
      <div class="row">

        <div class="col-lg-4">

          <div class="info-box">
          <span class="info-box-icon bg-green">
            <i class="fa fa-users"></i>
          </span>

            <div class="info-box-content">
              <span class="info-box-text">Befragte</span>
              <span class="info-box-number"><?php echo $num_respondents; ?></span>
            </div>
          </div>

        </div>

        <div class="col-lg-4">

          <div class="info-box">
          <span class="info-box-icon bg-green">
            <i class="fa fa-exclamation"></i>
          </span>

            <div class="info-box-content">
              <span class="info-box-text">Antworten</span>
              <span class="info-box-number"><?php echo $num_answers; ?></span>
            </div>
          </div>

        </div>
      </div>

      <div class="row">
        <div class="col-lg-8">

          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">
                Kurzanleitung
              </h3>
            </div>
            <div class="box-body">
              <ol>
                <li><b>Fragen</b> erstellen</li>
                <li><b>Fragebogen</b> aus Fragen zusammenstellen</li>
                <li>Basierend auf einem Fragebogen eine <b>Umfrage</b> erstellen</li>
                <li>Umfrage starten, <b>Live-Auswertung</b> verfolgen</li>
                <li>Umfrage beenden</li>
                <li>Daten nach SPSS <b>exportieren</b></li>
              </ol>
            </div>
          </div>

        </div>
      </div>
    </section>

  </div>

<?php require __DIR__ . "/../footer.php"; ?>