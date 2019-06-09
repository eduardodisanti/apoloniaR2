<?php
      $link = dbase_open("/srv/local/rvg/PATIENTS.DBF","r");

      $encontre = 0;
      $rowcount = dbase_numrecords($link);
      for($i=1; $i <= $rowcount; $i++)
        {
          $row = dbase_get_record_with_names($link,$i);
          if($row[SECU]==$cedula)
            {
              echo $row[NUMERO]."-".$row[NOM]."<br>\n";
              $encontre=1;
              break;
            }
        }
       dbase_close($link);
       if($encontre!=1)
           echo "<br>Error, no se ha encontrado el paciente";
    }
?>
