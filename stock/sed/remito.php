<?php

require_once("DB.php");
require_once("class/Mateo.phpm");
require_once("class/remito.phpm");
require_once("class/articulo.phpm");
require_once("class/LineasRemito.phpm");
require_once("class/ListaProveedores.phpm");

session_start();
$m = $_SESSION['mateo'];
$tema = $m->getTema();

  $dsn =  $m->db."://".$m->usuario.":".$m->clave."@".$m->servidor."/".$m->nombreDB;
  $conn = DB::connect($dsn);
  $conn->setFetchMode(DB_FETCHMODE_OBJECT);

  echo "<LINK href=\"css/$tema.css\" rel=\"stylesheet\" type=\"text/css\">\n";
 

  $lf = new ListaProveedores();
  $lf->init();
  $lf->setConn($conn);
  $lf->cargar(65536, "nombre", "asc");

  $proveedores = $lf->getLista();
  
//die($cmd."-".$xcdm);
  if(!empty($cmd) || !empty($xcmd))
   {

        $flag=false;
	
	$r = new Remito();
	$lr = new LineasRemito();
	
	$r->setConn($conn);
	$r->setSerie($serie);
	$r->setProveedor($proveedor);
	$r->setNumero($numero);
	
	if($r->cargar())
	  {	
	    $r->nuevo=false;
	    $flag=true;
	  }
	else
	    $r->nuevo=true; 

	$r->setFecha($fecha);

	if($cmd=="Actualizar")
	    $r->almacenar();
	
	
	if(!empty($xcmd))
	  {

	        $flag=true;
		$a = new Articulo();
		$a->setConn($conn);
		$a->setBarras($codigo);
		$a->cargarPorCodigo();
		
		$articulo=$a->getCodigo();
		
		$lr = new LineasRemito();
		$lr->setConn($conn);
		$lr->setSerie($serie);
		$lr->setProveedor($proveedor);
		$lr->setNumero($numero);
		$lr->setCantidad($cantidad);
		$lr->setElemento($elemento);
		switch($param)
		  {
			 case "dl" :
			    $lr->setLinea($linea);
			    $lr->borrar();
			    $cantidad=1;
			    $codigo=NULL;
			 break;
			 case "ed" :
			    $lr->setLinea($linea);
			    $lr->borrar();
			    $codigo=$articulo;
			 break;
			 case "Agregar" :
			    $lr->setLinea(0);
			    $lr->almacenar();
			    $cantidad=1;
			    $codigo=NULL;
			 break;
		  }
		$flag==true;
	  }

	if($flag) {
	  $fecha = $r->fecha;
	  $lr->setConn($conn);
	  $lr->setSerie($serie);
	  $lr->setProveedor($proveedor);
	  $lr->setNumero($numero);
	  $lr->cargar();
	  $lineas = $lr->getLista();
	} else {
		 echo "<h3>Error al cargar el remito</h3>";
	     }
   } else
        {
	   $fecha=Date("Y-m-d");
	}
  
  $conn->disconnect();

   include("templates/remito.phtml");
?>
