<?php

if(!isset($_SESSION["user_id"])) {
	$user = $_POST['email'];
	$pass = sha1(md5($_POST['password']));

	$u = UserData::getBy("username", $user);

	if($u && $u->password == $pass && $u->is_active) {
		$_SESSION['user_id'] = $u->id;
		print "Cargando ... $user";
		print "<script>window.location='./';</script>";
	} else {
		Core::alert("Usuario o contraseña incorrectos");
		print "<script>window.location='./';</script>";
	}
} else {
	print "<script>window.location='./';</script>";
}
?>
