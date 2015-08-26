<?php

$r = new EventData();
$r->title = $_POST["title"];
$r->description = $_POST["description"];
$r->project_id = $_POST["project_id"];
$r->category_id = $_POST["category_id"];
$r->date_at = $_POST["date_at"];
$r->time_at = $_POST["time_at"];
$r->user_id = $_SESSION["user_id"];
$r->add();

Core::redir("./index.php?view=reservations");
?>