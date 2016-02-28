<?php

if(count($_POST)>0){
	$user = NoteData::getById($_POST["id"]);
	$user->title = $_POST["title"];

	$category_id = "NULL";
	if($_POST["category_id"]!=""){ $category_id = $_POST["category_id"]; }
	$user->category_id = $category_id;

	$project_id = "NULL";
	if($_POST["project_id"]!=""){ $project_id = $_POST["project_id"]; }
	$user->project_id = $project_id;

	$user->description = htmlspecialchars($_POST["description"]);
	$user->update();


	print "<script>window.location='index.php?view=notes';</script>";


}


?>