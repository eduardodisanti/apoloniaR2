<?php
require_once("DB.php");
require_once("class/Mateo.phpm");
require_once("class/articulo.phpm");
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

  echo "<LINK href=\"css/$tema.css\" rel=\"stylesheet\" type=\"text/css\">\n";

  if(empty($icmd))
     $icmd="orden";
   
  if(empty($param))
     $param='nombre';
  if(empty($dir))
     $dir='asc';

  switch($icmd)
    {
 	case "orden" :
 	     if($param=='id')
 	        {
			$orden = "id";
 	        	$gifdir2="empty.gif";
 	        	if($dir=="asc")
 	        	  {
 	        	   $gifdir1='arrowup.gif';
 	        	   $dir="desc";
 	        	  }
 	        	else
 	        	  {
 	        	    $gifdir1='arrowdn.gif';
 	        	    $dir="asc";
 	        	  }
 	        } 
 	     else
 	     if($param=='nombre')
 	        {
			$orden = "nombre";
 	        	$gifdir1="empty.gif";
 	        	if($dir=="asc")
 	        	  {
 	        	   $gifdir2='arrowup.gif';
 	        	   $dir="desc";
 	        	  }
 	        	else
 	        	  {
 	        	    $gifdir2='arrowdn.gif';
 	        	    $dir="asc";
 	        	  }
 	        }
 		 break;
    }

       
   $lart = new ListaFamilias();
   $lart->setConn($conn);
   $lart->init();
   $lart->cargar(100, $orden, $dir);
   $lista=$lart->getLista();
   include("templates/familias.phtml");
   
  $conn->disconnect();
?>
