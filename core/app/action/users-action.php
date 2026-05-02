<?php
if(isset($_SESSION["user_id"])){
	if(isset($_GET["opt"]) && $_GET["opt"]=="add"){
		$u = new UserData();
		$u->name = $_POST["name"];
		$u->lastname = $_POST["lastname"];
		$u->username = $_POST["username"];
		$u->email = $_POST["email"];
		$u->password = sha1(md5($_POST["password"]));
		$u->is_admin = isset($_POST["is_admin"]) ? 1 : 0;
		$u->is_active = 1;
		$u->add();
		print "success";
	}
	else if(isset($_GET["opt"]) && $_GET["opt"]=="update"){
		$u = UserData::getById($_POST["id"]);
		$u->name = $_POST["name"];
		$u->lastname = $_POST["lastname"];
		$u->username = $_POST["username"];
		$u->email = $_POST["email"];
		if($_POST["password"]!=""){
			$u->password = sha1(md5($_POST["password"]));
			$u->update_passwd();
		}
		$u->is_admin = isset($_POST["is_admin"]) ? 1 : 0;
		$u->is_active = isset($_POST["is_active"]) ? 1 : 0;
		$u->update();
		print "success";
	}
	else if(isset($_GET["opt"]) && $_GET["opt"]=="del"){
		$u = UserData::getById($_GET["id"]);
		if($u->id != $_SESSION["user_id"]){
			$u->del();
			print "success";
		}
	}
}
?>
