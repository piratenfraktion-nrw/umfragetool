<?php require __DIR__ . "/../../header.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <?php

    $query = "SELECT * FROM `questionnaires` WHERE `id` = " . e($match['params']['id']);
    $result = DB::l()->query($query);

    $row = $result->fetch_assoc();

    if (!$row) {
      echo "Fragebogen existiert nicht.";
    } else {

      ?>

      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Fragebogen bearbeiten
          <small>ID: <?php ee($row['id']); ?></small>
        </h1>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">

          <div class="col-lg-6">

            <?php show_flash_message(); ?>

            <form method="post" action="">
              <input type="hidden" name="questionnaire_id" value="<?php ee($match['params']['id']); ?>">

              <div class="box box-primary">

                <div class="box-body">

                  <div class="form-group">
                    <label>Titel</label>
                    <input type="text" class="form-control" name="title" value="<?php ee($row['title']); ?>">
                  </div>

                  <div class="form-group">
                    <label>Beschreibung</label>
                    <textarea class="form-control" name="description"><?php ee($row['description']); ?></textarea>
                  </div>

                  <label>Fragen</label>
                  <ul class="list-unstyled column"><?php

                    $query = "SELECT *
                              FROM `questions` q, `questionnaires` qa, `questionnaires_questions` qq
                              WHERE qq.`question_id` = q.`id`
                              AND qq.`questionnaire_id` = qa.`id`
                              AND qa.`id` = " . e($match['params']['id']) . "
                              ORDER BY `position`;";

                    $result = DB::l()->query($query);

                    while ($row = $result->fetch_assoc()) {
                      ?>
                      <li class="alert alert-info" data-id="<?php ee($row['question_id']); ?>">
                      <input type="hidden" name="question_ids[]" value="<?php ee($row['question_id']); ?>">
                      <div class="pull-right">
                        ID: <?php ee($row['question_id']); ?>
                      </div>
                      <h4><?php ee($row['question_text']); ?></h4>
                      <?php ee(implode(" | ", json_decode($row['possible_answers']))); ?>
                      </li><?php } ?></ul>

                </div>
                <div class="box-footer text-right">
                  <a href="/admin/questionnaire" class="btn btn-warning" title="Zurück, OHNE Änderungen zu speichern">
                    <i class="fa fa-arrow-left"></i>
                  </a>
                  <button type="submit" class="btn btn-success" title="Änderungen speichern">
                    <i class="fa fa-save"></i>
                  </button>
                  <a href="<?php ee($router->generate("questionnaire-delete", array("id" => $match['params']['id']))); ?>" class="btn btn-danger btn-delete" title="Fragebogen löschen">
                    <i class="fa fa-trash"></i>
                  </a>
                </div>
              </div>
            </form>

          </div>

          <div class="col-lg-6">

            <div class="box box-primary">

              <div class="box-header">
                <h3 class="box-title">Liste aller Fragen</h3>
              </div>

              <div class="box-body">

                <ul class="list-unstyled column"><?php

                  $query = "SELECT *
                            FROM `questions`
                            WHERE `id` NOT IN (
                              SELECT `question_id`
                              FROM `questionnaires_questions`
                              WHERE `questionnaire_id` = " . e($match['params']['id']) . "
                            )
                            ORDER BY `question_text`";

                  $result = DB::l()->query($query);

                  while ($row = $result->fetch_assoc()) {
                    ?>
                    <li class="alert alert-info" data-id="<?php ee($row['id']); ?>">
                    <input type="hidden" name="question_ids[]" value="<?php ee($row['id']); ?>">
                    <div class="pull-right">
                      ID: <?php ee($row['id']); ?>
                    </div>
                    <h4><?php ee($row['question_text']); ?></h4>
                    <?php ee(implode(" | ", json_decode($row['possible_answers']))); ?>
                    </li><?php } ?></ul>

              </div>

            </div>

          </div>

        </div>
      </section>

    <?php } ?>

  </div>

<?php ob_start(); ?>
  <script type="text/javascript">

    $(".column").sortable({
      connectWith: ".column",
      placeholder: "alert alert-warning alert-placeholder"
    });
    $(".sortable").disableSelection();

    $("body").on("click", ".btn-delete", function () {
      return confirm("Fragebogen wirklich löschen? Enthaltene Fragen bleiben erhalten.");
    });

  </script>
<?php $meta['javascript'] = ob_get_clean(); ?>

<?php require __DIR__ . "/../../footer.php"; ?>