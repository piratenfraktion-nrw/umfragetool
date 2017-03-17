<?php

$query = "INSERT INTO `questions`
            (`question_text`, `possible_answers`)
          VALUES
            ('Neue Frage', '[\"\"]');";

$result = DB::l()->query($query);
$insert_id = DB::l()->insert_id;

header("Location: /admin/question/" . $insert_id);
