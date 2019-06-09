<?php
  require_once("DB.php");
  require_once("class/Mateo.phpm");
  require_once("class/almacen.phpm");

  session_start();
  $m = $_SESSION['mateo'];
  $tema = $m->getTema();

  echo "<LINK href=\"css/$tema.css\" rel=\"stylesheet\" type=\"text/css\">\n";  
  
  $dsn = $m->db."://".$m->usuarioDB.":".$m->clave."@".$m->servidor."/".$m->nombreDB;
  $conn = DB::connect($dsn);
  $conn->setFetchMode(DB_FETCHMODE_OBJECT);

  
  $a = new Almacen();
  $a->setConn($conn);
  
  if($cmd=="Actualizar")
    {
	$a->codigo		= $id;
	$a->descripcion		= $nombre;
	$a->mail		= $mail;
	$a->interno		= $interno;
	$a->sucursal		= $sucursal;
	$a->telefono		= $telefono;
        $a->controlado		= $controlado;

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
	     die("Error al cargar el almacen");
	  }
    
       $controlado              = $a->controlado;
       $mail			= $a->mail;
       $interno			= $a->interno;
       $sucursal		= $a->sucursal;
       $telefono		= $a->telefono;
       $nombre                  = $a->descripcion;
       $id			= $a->codigo;
        
    }

  $conn->disconnect();
  include("templates/almacen.phtml");
?>
