<?php
  require_once("DB.php");
  require_once("class/Mateo.phpm");
  require_once("class/articulo.phpm");
  require_once("class/ListaFamilias.phpm");

  session_start();
  $m = $_SESSION['mateo'];
  $tema = $m->getTema();

  echo "<LINK href=\"css/$tema.css\" rel=\"stylesheet\" type=\"text/css\">\n";  
  
  $dsn = $m->db."://".$m->usuarioDB.":".$m->clave."@".$m->servidor."/".$m->nombreDB;
  $conn = DB::connect($dsn);
  $conn->setFetchMode(DB_FETCHMODE_OBJECT);

  
  $a = new Articulo();
  $a->setConn($conn);
 
  if($cmd=="Borrar") {
     
     $a->codigo = $id;
     $a->borrar();
  }
  if($cmd=="Actualizar")
    {
	$a->codigo		= $id;
	$a->descripcion		= $nombre;
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
	$a->vence		= $vence;
	$a->impuestos		= $impuestos;

	$a->almacenar();
	$id = $a->codigo;  
    }
    
  if(empty($id))
    {
       $id=0;
       $peso=0;
       $volumen=0;
       $unidadAlmacen=0;
       $unidadExpedicion=0;
       $familia=0;
    }
  else
    {
       $a->setCodigo($id);
       if(!$a->cargar())
          {
	     die("Error al cargar el articulo");
	  }
     
       $peso			= $a->peso;
       $volumen			= $a->volumen;;
       $unidadAlmacen		= $a->unidadAlmacen;
       $unidadExpedicion	= $a->unidadExpedicion;
       $nombre			= $a->descripcion;
       $descUnidadCompra	= $a->descUnidadCompra;
       $descUnidadAlmacen	= $a->descUnidadAlmacen;
       $descUnidadExpedicion	= $a->descUnidadExpedicion;
       $familia 		= $a->familia;
       $barras			= $a->barras;
       $notas			= $a->notas;
       $vence			= $a->vence;
       $impuestos		= $a->impuestos; 
    }

  $lf = new ListaFamilias();
  $lf->setConn($conn);
  $lf->cargar(65536, "nombre", "asc");

  $familias = $lf->getLista();
  $conn->disconnect();
  include("templates/articulo.phtml");
?>
