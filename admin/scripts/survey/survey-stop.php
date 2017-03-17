<?php

$query = "UPDATE `surveys`
          SET `status` = 'stopped'
          WHERE `status` = 'live'";
DB::l()->query($query);

$_SESSION['flash_status'] = "success";
$_SESSION['flash_message'] = "Umfrage wurde beendet.";
header("Location: /admin/surveys/stopped");
exit;