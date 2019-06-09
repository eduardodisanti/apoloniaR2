<?php
       function procedimientos_pendientes($paciente)
         {
               $num=NULL; 
               return($num);
         }

       function tiene_pendientes($paciente)
        {
             // True, Flase, No tengo idea = NULL 
 
              $q = "select count(*) as cuenta from ParaHacer where Paciente=$paciente";

              $qry = mysql_query($q);
              $reg = mysql_fetch_object($qry); 
              $num = $reg->cuenta;

              if($num > 0)
                 $ret = TRUE;
              else
                  if($num == 0)
                     $ret = FALSE;
                  else
                     $ret = NULL;   //** ERROR ** OJO ***

              return($ret);
        }

        function agregarEpisodioAlta($paciente,$medico)
         {
           $fecha = date("Y-m-d");
           $hora=strtotime("now");
           $PROCALTA = 681;
           $query=mysql_query("insert into Episodios values($paciente,'$fecha', 999, $PROCALTA, '$hora','ALTA-S',$medico)");
           $query=mysql_query("insert into Altas values($paciente,'$fecha', '$hora', 'N','',0");

            
         }
?>
