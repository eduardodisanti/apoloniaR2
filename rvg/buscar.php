<?php

   include("../class/dbf_class.php");


   echo "<form action='buscar.php'>\n";

   if(empty($cmd))
      $cmd="Buscar";

   if($cmd=="Buscar")
     {
      $dbf = new dbf_class("imagenes/PATIENTS.DBF");

      if(empty($cadena))
            $cadena="A";

      echo "Apellido: ";
      echo "<input type='text' align='left' value='$cadena' name='cadena'>";
      echo "<input type='submit' name='cmd' value='Buscar'><br><br>";

      echo "<select name='pat' size=10 sorted>\n";
      $encontre = 0;
      $rowcount = $dbf->dbf_num_rec;
      for($i=1; $i <= $rowcount; $i++)
        {
          $row = $dbf->getRow($i);
          $cad = substr($row[1],0,strlen($cadena));
          if($cad==$cadena)
            {
              echo "<option value='$row[0]'>$row[1]</option>\n";
              $encontre=1;
            }
        }
    echo "</select><br>\n";
    echo "<input type='submit' name='cmd' value='Imagenes'>";
    echo "</form>";
   } else
        if($cmd=="Imagenes")
          {
            echo "<Center><h3>Imagenes de este paciente</h3></center>";
            $dir1 = substr($pat,0,1).".RVG"; 
            $dir2 = $pat;

            $dire = "imagenes/$dir1/$dir2";
            $handle = opendir($dire);
            while($file=readdir($handle))
             if($file >= "R")
              {
		$tstamp = filemtime("imagenes/$dir1/$dir2/$file");

		$fecha = date("Y-m-d",$tstamp);
		$hora  = date("H:i",$tstamp);
                echo "<a href='imagenes/$dir1/$dir2/$file' target='_blank'>$file ($fecha, $hora)</a><br>";
              }
            closedir($handle); 
          }
?>

