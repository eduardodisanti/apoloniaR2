<?php

require_once("marca.phpm");
require_once("tarjeta.phpm");
require_once("lista_de_usuarios.phpm");
require_once("imprimirtarjeta.phtml");



function elegido($listar, $funcionario)
{
  reset($listar);
  if(is_array($listar))
     {
        while(list(,$func)=each($listar))
           {
	     if($func == $funcionario)
	           return(true);
           }
     }
   
   return(false);
}

 if(empty($anio))
      $anio=Date("Y");

 if(empty($mes))
      $mes =Date("m");

  $anio=0+$anio;
  $mes=0+$mes;

$usuarios = new lista_de_usuarios();
$usuarios->setDB("mysql");
$usuarios->cargar();

$i = 0;
$cantfun = $usuarios->cantidad;

// * Loop de funcionarios *
for($i=0;$i<=$cantfun;$i++)
{

  $funcionario = $usuarios->lista[$i]->funcionario;
  $usuario     = $usuarios->lista[$i]->usuario;
  $medico      = $usuarios->lista[$i]->medico;

  if(elegido($listar, $usuario))
    {
       $tarjeta = new Tarjeta();
       $tarjeta->setDB("mysql");


       $tarjeta->setFuncionario($usuario);

       $f = $tarjeta->getFuncionario();
       $tarjeta->setAnio($anio);
       $tarjeta->setMes($mes);

       $TODALALISTA="TODA";
       tablaI($tarjeta);
       echo "<hr>";
    }
}

?>
