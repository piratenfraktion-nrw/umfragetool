<?php

$query = "INSERT INTO `questionnaires`
            (`title`, `description`)
          VALUES
            ('Neuer Fragebogen', 'Beschreibung des neuen Fragebogens.');";

$result = DB::l()->query($query);
$insert_id = DB::l()->insert_id;

header("Location: /admin/questionnaire/" . $insert_id);
