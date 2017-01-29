<!DOCTYPE html>
<?php
	session_start();
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

      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="hero-unit">
        <h1>Tienda virtual</h1>
        <p>En esta aplicación podrá realizar diferentes pedidos con diferentes artículos y consultarlos en cualquier momento.</p>
      </div>

		<div class="row">  
        <div class="span4">
          <h2>Artículos</h2>
          <p>Esta opción sirve para seleccionar los artículos que desee añadir a su cesta de la compra.</p>
          <p>
		  <?php 
		     if ($_SESSION["k_administrador"]=='S') {
		  ?><a class="btn btn-primary" href="productos_admin.php">
		  <?php } else{ ?>
			<a class="btn btn-primary" href="productos.php">
		  <?php } ?>Ver detalles</a></p>
        </div>
        <div class="span4">
          <h2>Cesta</h2>
          <p>Consultando la cesta de la compra podrá revisar los productos que ha seleccionado y validar su pedido. </p>
          <p><a class="btn btn-primary" href="cesta.php">Ver detalles &raquo;</a></p>
       </div>
        <div class="span4">
          <h2>Pedidos</h2>
          <p>Mediante esta opción podrá consultar sus diferentes pedidos realizados.</p>
          <p><a class="btn btn-primary" href="pedidos.php">Ver detalles</a></p>
        </div>
      </div>
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