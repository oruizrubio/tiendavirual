<?php
session_start();
// Borramos toda la sesion
session_destroy();
header('Location: index2.php');	
exit;
?>
