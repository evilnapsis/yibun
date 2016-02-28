<?php
$user = TaskData::getById($_GET["id"]);
$user->del();
print "<script>window.location='index.php?view=tasks';</script>";

?>