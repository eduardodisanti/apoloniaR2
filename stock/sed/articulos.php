<?php
require_once("DB.php");
require_once("class/Mateo.phpm");
require_once("class/articulo.phpm");
require_once("class/ListaArticulos.phpm");
require_once("class/ListaFamilias.phpm");

session_start();
$m = $_SESSION['mateo'];
$tema = $m->getTema();

  $dsn =   $m->db."://".$m->usuarioDB.":".$m->clave."@".$m->servidor."/".$m->nombreDB;

  $conn = DB::connect($dsn);
  $conn->setFetchMode(DB_FETCHMODE_OBJECT);

  echo "<LINK href=\"css/$tema.css\" rel=\"stylesheet\" type=\"text/css\">\n";

  if(empty($icmd))
     $icmd="orden";
   
  if(empty($param))
     $param='art';
  if(empty($dir))
     $dir='desc';

  switch($icmd)
    {
 	case "orden" :
 	     if($param=='fam')
 	        {
 			$orden = "familia";
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
 	     if($param=='art')
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


  if(empty($gifdir1))
      $gifdir1="arrowup.gif";
  if(empty($gifdir2))
      $gifdir2="arrowdn.gif";
       
   $lart = new ListaArticulos();
   $lart->init();
   $lart->setConn($conn);
   
   if(empty($begin))
      $begin = 0;
      
   $cantidadPagina    = 50;
   $lart->cargar(50000, $orden, $dir, $familia, $buscar);
   $lista=$lart->getLista();
   $cantidadArticulos = $lart->cantidad;
   $lart->begin = $begin;
   
   $lfam = new ListaFamilias();
   $lfam->init();
   $lfam->setConn($conn);
   $lfam->cargar(200, "nombre", "asc");
   
   $familias = $lfam->getLista();
   
   
   $conn->disconnect();
   
   include("templates/articulos.phtml");
?>
