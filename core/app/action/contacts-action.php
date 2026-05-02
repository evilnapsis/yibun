<?php
if(isset($_SESSION["user_id"])){
	if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
		$c = new ContactData();
		$c->name = $_POST["name"];
		$c->lastname = $_POST["lastname"];
		$c->email = $_POST["email"];
		$c->phone = $_POST["phone"];
		$c->address = $_POST["address"];
		$c->add();
		print "success";
	}
	else if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
		$c = ContactData::getById($_POST["id"]);
		$c->name = $_POST["name"];
		$c->lastname = $_POST["lastname"];
		$c->email = $_POST["email"];
		$c->phone = $_POST["phone"];
		$c->address = $_POST["address"];
		$c->update();
		print "success";
	}
	else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
		$c = ContactData::getById($_GET["id"]);
		$c->del();
		print "success";
	}
}
?>
