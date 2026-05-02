<?php
if(isset($_SESSION["user_id"])){
	if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
		$p = new ProjectData();
		$p->name = $_POST["name"];
		$p->description = $_POST["description"];
		$p->add();
		print "success";
	}
	else if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
		$p = ProjectData::getById($_POST["id"]);
		$p->name = $_POST["name"];
		$p->description = $_POST["description"];
		$p->update();
		print "success";
	}
	else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
		$p = ProjectData::getById($_GET["id"]);
		$p->del();
		print "success";
	}
}
?>
