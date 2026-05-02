<?php
if(isset($_SESSION["user_id"])){
	if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
		$n = new NoteData();
		$n->title = $_POST["title"];
		$n->description = $_POST["description"];
		$n->project_id = $_POST["project_id"];
		$n->category_id = $_POST["category_id"];
		$n->user_id = $_SESSION["user_id"];
		$n->add();
		print "success";
	}
	else if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
		$n = NoteData::getById($_POST["id"]);
		$n->title = $_POST["title"];
		$n->description = $_POST["description"];
		$n->project_id = $_POST["project_id"];
		$n->category_id = $_POST["category_id"];
		$n->update();
		print "success";
	}
	else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
		$n = NoteData::getById($_GET["id"]);
		$n->del();
		print "success";
	}
}
?>
