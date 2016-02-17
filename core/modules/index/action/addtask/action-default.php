<?php

$r = new TaskData();
$r->title = $_POST["title"];
$r->description = $_POST["description"];

$category_id = "NULL";
if($_POST["category_id"]!=""){ $category_id = $_POST["category_id"]; }
$r->category_id = $category_id;

$project_id = "NULL";
if($_POST["project_id"]!=""){ $project_id = $_POST["project_id"]; }
$r->project_id = $project_id;

$r->user_id = $_SESSION["user_id"];
$r->add();

Core::redir("./index.php?view=tasks");
?>