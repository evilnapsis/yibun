<?php
session_start();
unset($_SESSION["user_id"]);
session_destroy();
print "<script>window.location='./';</script>";
?>
