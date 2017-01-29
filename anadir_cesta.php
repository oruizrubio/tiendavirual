<?php
session_start();

require_once("Includes/db.php");

// verify user's credentials
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $rt = (Soul::getInstance()->anadir_cesta($_GET['codigo']));
    if ($rt != null) {
        session_start();
		$_SESSION["anadido"] = "S";
        header('Location: productos.php');
        exit;
    }
	else {
		$_SESSION["anadido"] = "E";
		header('Location: productos.php');
        exit;
	}
}
?>