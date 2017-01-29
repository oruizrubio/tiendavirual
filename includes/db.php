<?php

class Soul extends mysqli {

    // single instance of self shared among all instances
    private static $instance = null;
    // db connection config vars
    private $user = "root";
    private $pass = "soul";
    private $dbName = "soul";
    private $dbHost = "localhost";

    //This method must be static, and must return an instance of the object if the object
    //does not already exist.
    public static function getInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    // The clone and wakeup methods prevents external instantiation of copies of the Singleton class,
    // thus eliminating the possibility of duplicate objects.
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    public function __wakeup() {
        trigger_error('Deserializing is not allowed.', E_USER_ERROR);
    }

    // private constructor
    private function __construct() {
        parent::__construct($this->dbHost, $this->user, $this->pass, $this->dbName);
        if (mysqli_connect_error()) {
            exit('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }
        //parent::set_charset('utf-8');
    }

    public function consultar_producto($codigo) {
		return $this->query("SELECT codigo, nombre, precio, stock FROM productos WHERE codigo='" . $codigo . "'");
    }
	
	public function consultar_productos() {
        return $this->query("SELECT codigo, nombre, precio, stock, cdi_producto FROM productos");
    }
	
	public function consultar_pedidos() {
        return $this->query("SELECT cdi_pedido, importe, fecha FROM pedidos WHERE confirmado=true");
    }
	
	public function obtener_cesta() {
        $cesta = $this->query("SELECT cdi_pedido FROM pedidos WHERE confirmado=false and cdi_usuario = ".$_SESSION['k_cdiusu']);
		if ($cesta->num_rows > 0) {
			$row = $cesta->fetch_row();
            return $row[0];
		} else {
			$this->query("INSERT INTO pedidos (referencia, confirmado, importe, fecha, cdi_usuario) VALUES ('ref', false, 0, '".date("Y-m-d")."', ". $_SESSION['k_cdiusu'].")");
			$cesta = $this->query("SELECT cdi_pedido FROM pedidos WHERE confirmado=false and cdi_usuario = ".$_SESSION['k_cdiusu']);
			if ($cesta->num_rows > 0) {
				$row = $cesta->fetch_row();
				return $row[0];			
			}
		}
		return null;
    }	
		
	public function consultar_cesta() {
		$pedido = $this->obtener_cesta();
		if ($pedido != null) {
			return $this->query("SELECT cdi_pedido, importe, fecha FROM pedidos WHERE confirmado=false and cdi_usuario = ".$_SESSION['k_cdiusu']);
		} else {
			return null;
		}
    }		

	public function consultar_productos_cesta() {
		$pedido = $this->obtener_cesta();
		if ($pedido != null) {
			return $this->query("SELECT pedidos_productos.cantidad, pedidos_productos.precio, productos.nombre
									FROM pedidos_productos, productos
								   WHERE pedidos_productos.cdi_producto = productos.cdi_producto
									 AND pedidos_productos.cdi_pedido = ".$pedido);
		} else {
			return null;
		}
    }		

	public function anadir_cesta($cdi_producto) {
		$pedido = $this->obtener_cesta();	
		$valor = $this->query("SELECT precio FROM productos WHERE cdi_producto = ".$cdi_producto);	
		if ($valor->num_rows > 0) {
			$fila = $valor->fetch_row();
			$precio = $fila[0];
		} else {
			$precio = 0;
		}
		$cesta = $this->query("SELECT cdi_pedido_producto FROM pedidos_productos WHERE cdi_pedido=".$pedido." and cdi_producto = ".$cdi_producto);		
		if ($cesta->num_rows > 0) {
			$row = $cesta->fetch_row();
			$this->query("UPDATE pedidos_productos SET cantidad = cantidad + 1, precio = precio + ".$precio." WHERE cdi_pedido_producto = ".$row[0]);
		} else {
			$this->query("INSERT INTO pedidos_productos (cdi_pedido, cdi_producto, cantidad, precio) VALUES (".$pedido.", ".$cdi_producto.", 1, ".$precio.")");
		}
		$this->query("UPDATE productos SET stock = stock - 1 WHERE cdi_producto = ".$cdi_producto);	
		$this->query("UPDATE pedidos SET importe = importe + ".$precio." WHERE cdi_pedido = ".$pedido);			
		return $cesta;
    }	
	
	public function confirmar_cesta() {
		$pedido = $this->obtener_cesta();	
		$this->query("UPDATE pedidos SET confirmado = true WHERE cdi_pedido = ".$pedido);			
	}
	
	public function consultar_pedido($cdi_pedido) {
		return $this->query("SELECT cdi_pedido, importe, fecha FROM pedidos WHERE cdi_pedido=".$cdi_pedido);
    }	
	
	public function consultar_productos_pedido($pedido) {
			return $this->query("SELECT pedidos_productos.cantidad, pedidos_productos.precio, productos.nombre
									FROM pedidos_productos, productos
								   WHERE pedidos_productos.cdi_producto = productos.cdi_producto
									 AND pedidos_productos.cdi_pedido = ".$pedido);
    }	
	
    public function crear_usuario($name, $password, $password2, $nombre_completo, $email) {
        $name            = $this->real_escape_string($name);
        $password        = $this->real_escape_string($password);
		$password2       = $this->real_escape_string($password2);
		$nombre_completo = $this->real_escape_string($nombre_completo);
		$email           = $this->real_escape_string($email);
		if ($password <> $password2) {
			return "Las claves introducidas deben ser iguales";
		}
		if($name==NULL|$password==NULL|$password2==NULL|$email==NULL) {
			return "un campo está vacio.";		
		}
        $this->query("INSERT INTO usuarios (nombre_completo, usuario, password, email, fecha, administrador) VALUES ('" . $nombre_completo
                . "', '" . $name . "', '" . $password . "', '" . $email . "', '" . date("Y-m-d") . "', 'S')");
		return "0";
    }	
	
    public function insertar_producto($codigo, $nombre, $precio, $stock) {
        //$name = $this->real_escape_string($name);
        //$password = $this->real_escape_string($password);
        $this->query("INSERT INTO productos (codigo, nombre, precio, stock) VALUES ('" . $codigo
                . "', '" . $nombre . "', " . $precio . ", " . $stock . " )");
    }	
	
    public function comprobar_credenciales($name, $password) {
        $name = $this->real_escape_string($name);
        $password = $this->real_escape_string($password);
		return $this->query("SELECT cdi_usuario FROM usuarios WHERE usuario = '"
                        . $name . "' AND password = '" . md5($password) . "'");
						/*
        $result = $this->query("SELECT cdi_usuario FROM usuarios WHERE usuario = '"
                        . $name . "' AND password = '" . md5($password) . "'");
        return $result->data_seek(0);
		*/
    }

    public function comprobar_administrador($cdi_usuario) {
		return $this->query("SELECT administrador FROM usuarios WHERE cdi_usuario = ".$cdi_usuario);
    }	
	
    function format_date_for_sql($date) {
        if ($date == "")
            return null;
        else {
            $dateParts = date_parse($date);
            return $dateParts['year'] * 10000 + $dateParts['month'] * 100 + $dateParts['day'];
        }
    }

    public function actualizar_producto($codigo, $nombre, $precio, $stock) {
        //$description = $this->real_escape_string($description);
        $this->query("UPDATE productos SET codigo = '" . $codigo .
                "', nombre = '" . $nombre 
				. "', precio = " . $precio 
				. ", stock = " . $stock 
                . " WHERE codigo ='" . $codigo . "'");
    }	
	
    public function borrar_producto($codigo) {
        $this->query("DELETE FROM productos WHERE codigo = '" . $codigo . "'");
    }	
}

?>