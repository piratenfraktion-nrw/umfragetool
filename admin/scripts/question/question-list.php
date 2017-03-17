<?php require __DIR__ . "/../../header.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Fragen
        <small>Liste aller verfügbaren Fragen</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">

        <div class="col-lg-6 col-lg-push-6">
          <a href="/admin/question/add" class="btn btn-success btn-add">
            <i class="fa fa-fw fa-plus"></i> Hinzufügen
          </a>
        </div>

        <div class="col-lg-6 col-lg-pull-6">

          <?php

          show_flash_message();

          $query = "SELECT *
                    FROM `questions`
                    ORDER BY `id` DESC";
          $result = DB::l()->query($query);

          if ($result->num_rows < 1) {
            echo "Keine Fragen gefunden.";
          }

          while ($row = $result->fetch_assoc()) {
            ?>

            <div class="box box-primary">
              <div class="box-header">
                <div class="pull-right">
                  <?php ee("ID: " . $row['id']); ?>
                </div>
                <h3 class="box-title">
                  <?php ee($row['question_text']); ?>
                </h3>
              </div>
              <div class="box-body">
                <?php ee(implode(" | ", json_decode($row['possible_answers']))); ?>
              </div>
              <div class="box-footer text-right">
                <a href="<?php ee($router->generate("question-single", array("id" => $row['id']))); ?>" class="btn btn-warning">
                  <i class="fa fa-pencil"></i>
                </a>
                <a href="<?php ee($router->generate("question-delete", array("id" => $row['id']))); ?>" class="btn btn-danger btn-delete" title="Frage löschen">
                  <i class="fa fa-trash"></i>
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
      return confirm("Wirklich löschen? Wenn die Frage Teil eines Fragebogens ist, wird sie dort ebenfalls entfernt.");
    });

  </script>
<?php $meta['javascript'] = ob_get_clean(); ?>

<?php require __DIR__ . "/../../footer.php"; ?>