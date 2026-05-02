<?php
if(isset($_SESSION["user_id"])){
	if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
		$c = new CategoryData();
		$c->name = $_POST["name"];
		$c->description = $_POST["description"];
		$c->add();
		print "success";
	}
	else if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
		$c = CategoryData::getById($_POST["id"]);
		$c->name = $_POST["name"];
		$c->description = $_POST["description"];
		$c->update();
		print "success";
	}
	else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
		$c = CategoryData::getById($_GET["id"]);
		$c->del();
		print "success";
	}
}
?>
