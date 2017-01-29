<?php
session_start();

require_once("Includes/db.php");

// verify user's credentials
    $rt = (Soul::getInstance()->confirmar_cesta());
    session_start();
	$_SESSION["confirmada"] = "S";
    header('Location: pedidos.php');
    exit;
?>