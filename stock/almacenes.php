<?php
require_once("DB.php");
require_once("class/Mateo.phpm");
require_once("class/almacen.phpm");
require_once("class/ListaAlmacenes.phpm");

session_start();
$m = $_SESSION['mateo'];
$tema = $m->getTema();

  $dsn = $m->db."://".$m->usuarioDB.":".$m->clave."@".$m->servidor."/".$m->nombreDB;
  $conn = DB::connect($dsn);
  $conn->setFetchMode(DB_FETCHMODE_OBJECT);

  echo "<LINK href=\"css/$tema.css\" rel=\"stylesheet\" type=\"text/css\">\n";

  if(empty($icmd))
     $icmd="orden";
   
  if(empty($param))
     $param='nom';
  if(empty($dir))
     $dir='asc';

  switch($icmd)
    {
 	case "orden" :
 	     if($param=='suc')
 	        {
			$orden = "sucursal";
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
 	     if($param=='nom')
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

       
   $lart = new ListaAlmacenes();
   $lart->setConn($conn);
   $lart->init();
   $lart->cargar(20, $orden, $dir);
   $lista=$lart->getLista();
   include("templates/almacenes.phtml");
   
  $conn->disconnect();
?>
