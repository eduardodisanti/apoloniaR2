<?php
  require_once("DB.php");
  require_once("class/Mateo.phpm");
  require_once("class/articulo.phpm");
  require_once("class/ListaFamilias.phpm");

  session_start();
  $m = $_SESSION['mateo'];
  $tema = $m->getTema();

  echo "<LINK href=\"css/$tema.css\" rel=\"stylesheet\" type=\"text/css\">\n";  
  
  $dsn = $m->db."://".$m->usuario.":".$m->clave."@".$m->servidor."/".$m->nombreDB;
  $conn = DB::connect($dsn);
  $conn->setFetchMode(DB_FETCHMODE_OBJECT);

  $a = new Articulo();
  
  $a->setConn($conn);
  
  $a->codigo		= $id;
  $a->descripcion	= $nombre;
  $a->familia		= $familia;
  $a->volumen		= $volumen;
  $a->peso		= $peso;
  $a->unidadCompra	= $unidadCompra;
  $a->unidadAlmacen	= $unidadAlmacen;
  $a->unidadExpedicion	= $unidadExpedicion;
  $a->descUnidadCompra	= $descUnidadCompra;
  $a->descUnidadAlmacen	= $descUnidadAlmacen;
  $a->descUnidadExpedicion= $descUnidadExpedicion;
  $a->barras		= $barras;
  $a->notas		= $notas;
  
  $a->almacenar();
  
  $id = $a->codigo;

  $lf = new ListaFamilias();
  $lf->setConn($conn);
  $lf->cargar(65536, "nombre", "asc");

  $familias = $lf->getLista();
       
  $conn->disconnect();
  include("templates/articulo.phtml");
?>