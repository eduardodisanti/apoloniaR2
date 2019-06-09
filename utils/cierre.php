<?php

 $link=mysql_connect("127.0.0.1","root","virgen") or die("Error, la base de dato
s no acepto la coneccion");
 mysql_select_db("apolonia");

 $q = mysql_query("select * from CuentaCorriente where TipoMov='D' order by Paciente,Fecha");

   while($reg = mysql_fetch_object($q))
    {
      $paciente = $reg->Paciente;
      $tipoOrd  = $reg->TipoOrden;
      $fecha    = $reg->Fecha;
      $ordenesDebe= $reg->ImporteOrdenes;
      $hora     = $reg->Hora;
      $procedimiento = $reg->Procedimiento;
      $pieza	= $reg->Pieza;

      // * Para cada debe busco un haber que lo mate
      $qh = "select * from CuentaCorriente where Paciente=$paciente and TipoMov='H' and Fecha >= '$fecha' and TipoOrden='$tipoOrd'";
      echo "$qh\n";
      $haberes = mysql_query($qh); 
      $hreg = mysql_fetch_object($haberes);
      if(!empty($hreg))
        {
          $ordenesPagas = $hreg->ImporteOrdenes; 
          $hfecha = $hreg->Fecha;
          $hhora  = $hreg->hhora;
          $saldo = $ordenesDebe - $ordenesPagas;
          if($saldo == 0) // pago exacto pelo los dos movimientos
            {
               mysql_query("delete from CuentaCorriente where Paciente='$paciente' and Fecha='$fecha' and Hora='$hora' and Pieza=$pieza and Procedimiento=$procedimiento"); 
               mysql_query("delete from CuentaCorriente where Paciente='$pacient
e' and Fecha='$hfecha' and Hora='$hhora' and Pieza=$pieza and Procedimiento=$pro
cedimiento");
            } 
          else
             if($saldo > 0) // ** debe mas de lo que pago
                {
                    mysql_query("update CuentaCorriente set ImoprteOrdenes = $saldo where Paciente='$paciente' and Fecha='$fecha' and Hora='$hora' and Pieza=$pieza and Procedimiento=$procedimiento");
                    mysql_query("delete from CuentaCorriente where Paciente='$paciente' and Fecha='$hfecha' and Hora='$hhora' and Pieza=$pieza and Procedimiento=$procedimiento");
                }
             else // pago mas de lo que debe
                {
                    $saldo = abs($saldo);
                    mysql_query("update CuentaCorriente set ImporteOrdenes = $saldo where Paciente='$paciente' and Fecha='$hfecha' and Hora='$hhora' and Pieza=$pieza and Procedimiento=$procedimiento");

               mysql_query("delete from CuentaCorriente where Paciente='$paciente' and Fecha='$fecha' and Hora='$hora' and Pieza=$pieza and Procedimiento=$procedimiento");
                }   
        }
    }

 mysql_close();
?>
