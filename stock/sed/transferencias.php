<?php

require_once("DB.php");
require_once("class/Mateo.phpm");
require_once("class/transferencia.phpm");
require_once("class/LineasTransferencia.phpm");
require_once("class/ListaAlmacenes.phpm");

session_start();
$m = $_SESSION['mateo'];
$tema = $m->getTema();

  $dsn =  $m->db."://".$m->usuario.":".$m->clave."@".$m->servidor."/".$m->nombreDB;
  $conn = DB::connect($dsn);
  $conn->setFetchMode(DB_FETCHMODE_OBJECT);

  echo "<LINK href=\"css/$tema.css\" rel=\"stylesheet\" type=\"text/css\">\n";
 

  $lf = new ListaAlmacenes();
  $lf->init();
  $lf->setConn($conn);
  $lf->cargar(65536, "nombre", "asc");

  $almacenes = $lf->getLista();
  
  if($cmd=="Consultar")
   {
	$r = new Transferencia();
	$r->setConn($conn);
	$r->setNumero($numero);
	
	if($r->cargar()) {

	  $fecha = $r->fecha;
	  $lr = new LineasTransferencia();
	  $lr->setConn($conn);
	  $lr->setNumero($numero);
	  $lr->cargar();
	  $lineas = $lr->getLista();
	  $destino = $r->destino;
	  $almacen = $r->almacen;
	} else {
		 echo "<h3>Error al cargar la transferencia</h3>";
	     }
   }
  
  $conn->disconnect();

   include("templates/transferencias.phtml");
?>