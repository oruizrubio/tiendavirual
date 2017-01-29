<?php
session_start();

require_once("Includes/db.php");

// verify user's credentials
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $logonSuccess = (Soul::getInstance()->comprobar_credenciales($_POST['usuario'], $_POST['password']));
    if ($logonSuccess != null) {
        session_start();
		$_SESSION["k_username"] = $_POST['usuario'];
		$_SESSION["errorAcceso"] = "N";
		$row = mysqli_fetch_array($logonSuccess);
		$_SESSION["k_cdiusu"] = $row[0];
		$admin = (Soul::getInstance()->comprobar_administrador($_SESSION["k_cdiusu"]));
		$row = mysqli_fetch_array($admin);
		$_SESSION["k_administrador"] = $row[0];		
        header('Location: index2.php');
        exit;
    }
	else {
		$_SESSION["errorAcceso"] = "S";
		header('Location: login2.php');
        exit;
	}
}
?>