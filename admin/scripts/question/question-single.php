<?php require __DIR__ . "/../../header.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <?php

    $query = "SELECT * FROM `questions` WHERE `id` = " . e($match['params']['id']);
    $result = DB::l()->query($query);

    $row = $result->fetch_assoc();

    if (!$row) {
      echo "Frage existiert nicht.";
    } else {

      ?>

      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Frage bearbeiten
          <small>ID: <?php ee($row['id']); ?></small>
        </h1>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-lg-6">

            <?php show_flash_message(); ?>

            <form method="post" action="">
              <input type="hidden" name="question_id" value="<?php ee($match['params']['id']); ?>">
              <div class="box box-primary">

                <div class="box-body">

                  <div class="form-group">
                    <label>Frage</label>
                    <input type="text" class="form-control" name="question_text" value="<?php ee($row['question_text']); ?>">
                  </div>

                  <label>Antwortmöglichkeiten</label>
                  <div>

                  <?php

                  $answers = json_decode($row['possible_answers']);

                  foreach ($answers as $answer) {
                    ?>
                    <div class="row answer-row">
                      <div class="col-lg-10">
                        <div class="form-group">
                          <input type="text" class="form-control" name="possible_answers[]" value="<?php ee($answer); ?>">
                        </div>
                      </div>
                      <div class="col-lg-2">
                        <a href="#" class="remove-row">
                          <i class="fa fa-2x fa-minus-circle"></i>
                        </a>
                      </div>
                    </div>
                  <?php } ?>

                  </div>

                  <div class="row">
                    <div class="col-lg-2">
                      <a href="#" class="add-row">
                        <i class="fa fa-2x fa-plus-circle"></i>
                      </a>
                    </div>
                  </div>

                </div>
                <div class="box-footer text-right">
                  <a href="/admin/question" class="btn btn-warning" title="Zurück, OHNE Änderungen zu speichern">
                    <i class="fa fa-arrow-left"></i>
                  </a>
                  <button type="submit" class="btn btn-success" title="Änderungen speichern">
                    <i class="fa fa-save"></i>
                  </button>
                  <a href="<?php ee($router->generate("question-delete", array("id" => $row['id']))); ?>" class="btn btn-danger btn-delete" title="Frage löschen">
                    <i class="fa fa-trash"></i>
                  </a>
                </div>
              </div>
            </form>

          </div>
        </div>
      </section>

    <?php } ?>

  </div>

<?php ob_start(); ?>
  <script type="text/javascript">

    $(".add-row").click(function (e) {

      e.preventDefault();

      $(".answer-row").first()
        .clone()
        .insertAfter($(".answer-row").last())
        .find("input")
        .val("");

    });

    $("body").on("click", ".remove-row", function (e) {

      e.preventDefault();

      if ($(".answer-row").length == 1)
        return;

      $(e.currentTarget).parents(".answer-row").remove();

    });

    $("body").on("click", ".btn-delete", function () {
      return confirm("Wirklich löschen? Wenn die Frage Teil eines Fragebogens ist, wird sie dort ebenfalls entfernt.");
    });

  </script>
<?php $meta['javascript'] = ob_get_clean(); ?>

<?php require __DIR__ . "/../../footer.php"; ?>