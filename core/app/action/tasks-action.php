<?php
if(isset($_SESSION["user_id"])){
	if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
		$t = new TaskData();
		$t->title = $_POST["title"];
		$t->description = $_POST["description"];
		$t->project_id = $_POST["project_id"];
		$t->category_id = $_POST["category_id"];
		$t->user_id = $_SESSION["user_id"];
		$t->is_done = 0;
		$t->add();
		print "success";
	}
	else if(isset($_GET["opt"]) && $_GET["opt"]=="done"){
		$t = TaskData::getById($_GET["id"]);
		$t->is_done = $_GET["is_done"];
		$t->done();
		print "success";
	}
	else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
		$t = TaskData::getById($_GET["id"]);
		$t->del();
		print "success";
	}
}
?>
