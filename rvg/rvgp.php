<?php

function paciente($cedula){

    $cedula=strtok($cedula," ");
    return obtengodatos($cedula);
}

function obtengodatos($cedula)
  {

      $link = dbase_open("/srv/local/rvg/PATIENTS.DBF","r");
      $encontre = 0;
      $rowcount = dbase_numrecords($link);
      for($i=1; $i <= $rowcount; $i++)
        {
          $row = dbase_get_record_with_names($link,$i);

          $token=strtok($row[CODE]," ");
          $token1=strtok($row[SECU], " ");
          if($token==$cedula || $token1==$cedula)
            {
              $encontre=1;
              break;
            }
        }
       dbase_close($link);
       if($encontre!=1)
           return;
       else
           return($row[NUMERO]);
    }

  $directorio = obtengodatos($cedula);
  $token=substr($directorio,0,1);
  $directorio1="$token.RVG";
  if(!empty($directorio))
      {
         // *** Aca hago el laburo de ver las imagenes y mostrarlas ***

         $path="/home/local/rvg/$directorio1/$directorio";
         $dir=opendir($path);
         while($file=readdir($dir))
          {
             if($file >= "R")
              { 
                echo "$file<br><img src=\"../rvg/$directorio1/$directorio/$file\">"."<br>"; 
              }
          }
         closedir($dir); 
      }
?>

