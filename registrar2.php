<!DOCTYPE html>
<?php
	session_start();
	require_once("Includes/db.php");
?>
<html lang="es">
  <head>
    <meta charset="ISO-8859-1">
    <title>Curso, Tienda Virtual</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="ico/favicon.png">
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#">Tienda Virtual</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="index2.php">Inicio</a></li>
              <li><?php if ($_SESSION["k_administrador"]=='S') {
					?><a href="productos_admin.php">Artículos
				  <?php } else{ ?>
					  <a href="productos.php">Artículos
				  <?php } ?></a></li>
              <li><a href="cesta.php">Cesta</a></li>
              <li><a href="pedidos.php">Pedidos</a></li>			  
            </ul>
			<?php if (isset($_SESSION['k_username'])) { ?>
            <form action="logout.php" class="navbar-form pull-right">
				<ul class="nav">
				  <?php echo '<li><a href="#"> Bienvenido, <b>'.$_SESSION['k_username'].'</a></li>'; ?>
				  <button type="submit" class="btn">Desconectar</button>
                </ul>
			  <!--?php echo 'Bienvenido, <b>'.$_SESSION['k_username']; ?-->
            </form>
			<?php } else { ?>
            <form action="login2.php" class="navbar-form pull-right">
              <button type="submit" class="btn">Conectar</button>
            </form>			
			<?php } ?>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>


    <div class="container">

<?php
	session_start();
	$accion = $_GET["accion"];
	if (!isset($accion)) {
		echo "
			<form action=\"registrar2.php?accion=guardar\" method=\"post\">
			<p> Nombre completo (max 100): <br>
			  <input type=\"text\" name=\"nombre_completo\" size=\"50\" maxlength=\"100\" /></p>
			<p> Usuario (max 20): <br>
			  <input type=\"text\" name=\"username\" size=\"20\" maxlength=\"20\" /></p>
			<p> Password (max 10): <br>
			<input type=\"password\" name=\"password\" size=\"10\" maxlength=\"10\" /> 
			<p> Confirma password: <br> <input type=\"password\" name=\"password2\" size=\"10\" maxlength=\"10\" /></p>
			<p> Email (max 40): <br>
			<input type=\"text\" name=\"email\" size=\"20\" maxlength=\"40\" /></p>
			<p> <input type=\"submit\" value=\"Registrar\" />
			</form>";
	} elseif ($accion=="guardar") {
			$rt = Soul::getInstance()->crear_usuario($_POST["username"], md5($_POST["password"]), md5($_POST["password2"]), $_POST["nombre_completo"], $_POST["email"]);
            $_SESSION["registrado"] = "S";		
			header('Location: login2.php');	
			exit;		
	}
	?>

      <hr>

      <footer>
        <p>&copy; Tienda Virtual 2013</p>
      </footer>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-alert.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-dropdown.js"></script>
    <script src="js/bootstrap-scrollspy.js"></script>
    <script src="js/bootstrap-tab.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>
    <script src="js/bootstrap-button.js"></script>
    <script src="js/bootstrap-collapse.js"></script>
    <script src="js/bootstrap-carousel.js"></script>
    <script src="js/bootstrap-typeahead.js"></script>

  </body>
</html>