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
              <li><a href="index2.php">Inicio</a></li>
              <li><?php if ($_SESSION["k_administrador"]=='S') {
					?><a href="productos_admin.php">Artículos
				  <?php } else{ ?>
					  <a href="productos.php">Artículos
				  <?php } ?></a></li>
              <li><a href="cesta.php">Cesta</a></li>
              <li class="active"><a href="pedidos.php">Pedidos</a></li>			  
            </ul>
			<?php if (isset($_SESSION['k_username'])) { ?>
            <form action="logout.php" class="navbar-form pull-right">
				<ul class="nav">
				  <?php echo '<li><a href="#"> Bienvenido, <b>'.$_SESSION['k_username'].'</b></a></li>'; ?>
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

	if (isset($_SESSION['k_username'])) {

		echo "<h2> Consulta de pedidos </h2>";
		echo "<h3> Pedido </h3>";		
		echo "<table class=\"table table-bordered table-striped\">
		<thead>
		<tr>
			<th>Referencia</th><th>Fecha</th><th>Precio</th>
		</tr>
		</thead>
		<tbody>";
		$result = Soul::getInstance()->consultar_pedidos();
		while ($row = mysqli_fetch_array($result)){
		echo "<tr>
			<td><a href=\"consultar_pedido.php?cdi_pedido=$row[0]\"> $row[0]</a></td><td>$row[2]</td><td>$row[1]</td>
			</tr>";
		}	
		echo "</tbody></table>";
		if ($result==0) {
			echo "No hay pedidos dados de alta en la base de datos";
		}	
	}
	else {
		echo "Debe estar conectado para acceder a la información";
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