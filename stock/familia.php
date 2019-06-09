<?php
  require_once("DB.php");
  require_once("class/Mateo.phpm");
  require_once("class/familia.phpm");
  require_once("class/ListaFamilias.phpm");

session_start();
  $m      = new Mateo();
    $tema   = $m->getTema();
      $empresa=$m->getInstitucion();
        $logo   = $m->getLogo();

	  $m->setUsuario($usuario);
	    $_SESSION['mateo']=$m;

	      $dsn = $m->db."://".$m->usuarioDB.":".$m->clave."@".$m->servidor."/".$m->nombreDB;

	       $conn = DB::connect($dsn);

  $conn->setFetchMode(DB_FETCHMODE_OBJECT);

  
  $f = new Familia();
  $f->setConn($conn);
  
  if($cmd=="Actualizar")
    {
	$f->codigo		= $id;
	$f->descripcion		= $nombre;

	$f->almacenar();
	$id = $f->codigo;  
    }
    
  if(empty($id))
    {
       $id=0;
    }
  else
    {
       $f->setCodigo($id);
       if(!$f->cargar())
          {
	     die("Error al cargar la familia");
	  }
     
       $nombre = $f->descripcion;     
    }

  $conn->disconnect();
  include("templates/familia.phtml");
?>
