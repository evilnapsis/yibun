<?php
if(isset($_SESSION["user_id"])){
	if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
		$e = new EventData();
		$e->title = $_POST["title"];
		$e->description = $_POST["description"];
		$e->date_at = $_POST["date_at"];
		$e->time_at = $_POST["time_at"];
		$e->project_id = $_POST["project_id"];
		$e->category_id = $_POST["category_id"];
		$e->user_id = $_SESSION["user_id"];
		$e->add();
		print "success";
	}
	else if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
		$e = EventData::getById($_POST["id"]);
		$e->title = $_POST["title"];
		$e->description = $_POST["description"];
		$e->date_at = $_POST["date_at"];
		$e->time_at = $_POST["time_at"];
		$e->project_id = $_POST["project_id"];
		$e->category_id = $_POST["category_id"];
		$e->update();
		print "success";
	}
	else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
		$e = EventData::getById($_GET["id"]);
		$e->del();
		print "success";
	}
}
?>
