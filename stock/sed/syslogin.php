<?php

require_once('DB.php');
require_once('class/Mateo.phpm');
require_once('class/Usuario.phpm');

session_start();
  $m      = new Mateo();
  $tema   = $m->getTema();
  $empresa=$m->getInstitucion();
  $logo   = $m->getLogo();

  $m->setUsuario($usuario);
  $_SESSION['mateo']=$m;

  $dsn = $m->db."://".$m->usuarioDB.":".$m->clave."@".$m->servidor."/".$m->nombreDB;
 
 $conn = DB::connect($dsn);

  if(DB::isError($conn))
     {
       die("Error de coneccion: ".$conn->getMessage());
     } else
        $conn->setFetchMode(DB_FETCHMODE_OBJECT);

 // primero validamos el usuario
    $u = new Usuario($usuario, $clave, $conn);
    if(empty($u) || ($u->clave != $clave))
      {
         $HAY_PROBLEMAS=true;
         $PROBLEMA="Datos de ingreso inválidos";
      } else
           {
	     $HAY_PROBLEMAS=false;
             $PROBLEMA="";
	   }
    
    require("templates/justlogin.phtml");
?>

