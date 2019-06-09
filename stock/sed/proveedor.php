<?php
  require_once("DB.php");
  require_once("class/Mateo.phpm");
  require_once("class/proveedor.phpm");

  session_start();
  $m = $_SESSION['mateo'];
  $tema = $m->getTema();

  echo "<LINK href=\"css/$tema.css\" rel=\"stylesheet\" type=\"text/css\">\n";  
  
  $dsn = $m->db."://".$m->usuarioDB.":".$m->clave."@".$m->servidor."/".$m->nombreDB;
  $conn = DB::connect($dsn);
  $conn->setFetchMode(DB_FETCHMODE_OBJECT);

  
  $a = new Proveedor();
  $a->setConn($conn);
  
  if($cmd=="Actualizar")
    {
	$a->codigo	= $id;
	$a->descripcion	= $nombre;
	$a->telefono	= $telefono;
	$a->fax		= $fax;
	$a->mail	= $mail;
	$a->web		= $web;
	$a->domicilio	= $domicilio;
	$a->formapago	= $formapago;
	$a->contacto	= $contacto;

	$a->almacenar();
	$id = $a->codigo;  
    }
    
  if(empty($id))
    {
       $id=0;
    }
  else
    {
       $a->setCodigo($id);
       if(!$a->cargar())
          {
	     die("Error al cargar el proveedor");
	  }
	  
	$id		= $a->codigo;
	$nombre 	= $a->descripcion;
	$telefono 	= $a->telefono;
	$fax 		= $a->fax;
	$mail 		= $a->mail;
	$web 		= $a->web;
	$domicilio 	= $a->domicilio;
	$formapago 	= $a->formapago;
	$contacto 	= $a->contacto;
    }

  $conn->disconnect();
  include("templates/proveedor.phtml");
?>
