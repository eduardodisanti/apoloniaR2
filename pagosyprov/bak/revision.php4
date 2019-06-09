<?php
    if(!empty($paciente))
           setcookie("apoloniaPaciente",0);    
?>
<HTML>
<HEAD>
	<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=iso-8859-1">
	<TITLE></TITLE>
	<META NAME="GENERATOR" CONTENT="StarOffice/5.2 (Win32)">
	<META NAME="CREATED" CONTENT="20010607;10182931">
	<META NAME="CHANGEDBY" CONTENT="Eduardo Di Santi">
	<META NAME="CHANGED" CONTENT="20010607;11381431">
</HEAD>
<BODY BGCOLOR="#9999cc">
<FORM NAME="revision" method="post" action="revision.php">
<HR>
<FONT COLOR="#800000"><FONT FACE="Arial, sans-serif"><FONT SIZE=4>          Revisi&oacute;n Odontologica </FONT></FONT></FONT>
<FONT SIZE=4>Paciente :
<?php
    if(!empty($paciente))
    {
      $link=mysql_connect("127.0.0.1","root","virgen") or
                         die("Error, no se puede abrir la base de datos".mysql_error());
      $db=mysql_select_db("apolonia"); 
    if($COMENTANDO=="SI")
      {
         $coment=mysql_query("delete from Comentarios where Paciente=$paciente");
         $coment=mysql_query("insert into Comentarios values($paciente, '$comentario')");
      } 
      $query=mysql_query("select * from Pacientes where Cedula=$paciente") or 
          die("No se pudo encontrar el paciente $paciente : ".mysql_error());
      $rowi=mysql_fetch_object($query); 
      $Nombre=$rowi->Nombre;
      $Seguro=$rowi->Seguro;
      $Paga=$rowi->Paga;
      mysql_close();
      echo $Nombre." (".$Seguro.")";
      if($Paga=="S")
          echo " <b>debe abonar</b>\n";
    } 
   echo "<HR>";
   if($ACCION=="UPDATE")
    {
      $link=mysql_connect("127.0.0.1","root","virgen") or
                         die("Error, no se puede abrir la base de datos".mysql_error());
      $db=mysql_select_db("apolonia"); 
 
      if(empty($DIENTE))
            $DIENTE="999-";
 
      if(!empty($DIENTE))
        {
         $tok=strtok($DIENTE,"-");
         while($tok)
           { 
            echo "$tok<BR>";
            $query=mysql_query("select Pieza from Piezas where Indice=$tok") or 
                 die("No se pudo encontrar La Pieza : ".mysql_error());
            $rowi=mysql_fetch_object($query); 
            $Pieza=$rowi->Pieza;
            echo "Actualizando Pieza: $Pieza";
$query1=mysql_query("select * from Diagnosticos where Paciente=$PACIENTE and Pieza=$Pieza") or 
                 die("Error en la consulta ".mysql_error()."select * from Diagnosticos where Paciente=$PACIENTE and Pieza=$Pieza");
            if($pepi=mysql_fetch_object($query1))
               {    
                    $query2=mysql_query("update Diagnosticos set Diagnostico='$tbComentario' where Paciente=$PACIENTE and Pieza=$Pieza") or
                                die("No se puede actualizar(update), error ".mysql_error());
                    echo(" OK<BR>");
               } else
                  {
                    $query2=mysql_query("insert into Diagnosticos values($PACIENTE,$Pieza,'$tbComentario', $coifuncionario)") or
                                die("No se puede insertar, error ".mysql_error()."\n insert into Diagnosticos values($PACIENTE,$Pieza,'$tbComentario', $coifuncionario)");
                    echo(" OK!<BR>");
                    $query2=mysql_query("delete from Asistencia where Paciente=$PACIENTE");
                  }
             
           reset($marked);
           if(is_array($marked))      
             {
              while(list($dummy,$Proci)=each($marked))
               {
                //$Proc=strtok($Proci,")");
                list($Proc,$dumito,$Nom)=split(')',$Proci);
                echo "$Proc $Nom";
                $query3=mysql_query("select * from ParaHacer where Paciente=$PACIENTE and Pieza=$Pieza and Procedimiento=$Proc") or
                   die("Error en la consulta ParaHacer".mysql_error());
                if($pepi=mysql_fetch_object($query3))
                  {
                    $query4=mysql_query("update ParaHacer set Paciente=$PACIENTE, Pieza=$Pieza, Procedimiento=$Proc where Paciente=$PACIENTE and Pieza=$Pieza and Procedimiento=$Proc") or
                                die("No se puede actualizar, error ".mysql_error());
                  }else
                  {
                    $query4=mysql_query("insert into ParaHacer values($PACIENTE,$Pieza,$Proc)") or
                                die("No se puede insertar, error ".mysql_error());
                  }
               }
             }
            $tok=strtok("-");
           } 
        }    
      echo("Actualizado correctamente <A HREF=revision.php?paciente=$PACIENTE>Pulse aqui para volver</A>");
      echo "<hr><h2><center><font color=\"#FFFFFF\">Comentarios para Recepcion y Att. Telefonica</font></center></h2>";
      echo "<center><textarea name=\"comentario\" cols=60 rows=5></textarea><br>";
      echo "<input type=\"HIDDEN\" name=\"paciente\" value=\"$PACIENTE\">";
      echo "<input type=\"HIDDEN\" name=\"COMENTANDO\" value=\"SI\">";
      echo "<input type=\"submit\" value=\"Actualizar\" name=\"xx\"></center>";
      mysql_close();      
      die();
    }   
?>
</FONT>
<TABLE WIDTH=100% BORDER=0 BORDERCOLOR="#000000" BGCOLOR="#ccccff" CELLPADDING=0 CELLSPACING=0>
	<COL WIDTH=70*>
	<COL WIDTH=64*>
	<COL WIDTH=36*>
	<COL WIDTH=86*>
	<TR VALIGN=TOP>
		<TD WIDTH=27%>
                  <MAP NAME="MAP1">
                  <?php
                     echo "<AREA SHAPE=RECT COORDS=\"30,136,53,160\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."52-\">\n";
                     echo "<AREA SHAPE=RECT COORDS=\"40,165,57,187\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."51-\">\n";
                     echo "<AREA SHAPE=RECT COORDS=\"57,187,70,203\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."50-\">\n";
                     echo "<AREA SHAPE=RECT COORDS=\"70,198,82,213\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."49-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"82,202,96,218\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."48-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"96,200,110,218\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."47-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"113,198,126,212\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."46-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"126,185,141,200\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."45-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"137,161,156,187\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."44-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"137,134,166,161\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."43-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"141,65,168,96\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."42-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"139,52,160,65\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."41-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"129,37,146,52\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."40-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"116,23,133,37\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."39-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"97,16,116,36\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."38-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"80,16,97,36\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."37-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"62,23,79,39\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."36-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"50,37,66,52\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."35-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"40,51,60,72\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."34-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"29,72,60,100\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."33-\">";
                  echo "</MAP>";
                  echo "<IMG SRC=\"bocatemporal.jpg\" NAME=\"Imagen1\" ALIGN=LEFT WIDTH=196 HEIGHT=265 BORDER=0 USEMAP=\"#MAP1\"><BR CLEAR=LEFT><BR>\n";
                  echo "<A HREF=\"conshist.php3?paciente=$paciente\" target=\"_historia\">Ver historia</A><BR>"; 
                     echo "<A HREF=\"revision.php?paciente=$paciente&diente=$diente"."999-\">Toda la boca</A><BR>";
                     echo "<A HREF=\"revision.html\">Otro Paciente</A>";
		echo "</TD>";
		echo "<TD WIDTH=25%>";
                echo "  <MAP NAME=\"MAP2\">";
	        
                echo "<AREA SHAPE=RECT COORDS=\"242,194,273,229\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."16-\">";
	        echo "<AREA SHAPE=RECT COORDS=\"231,153,269,191\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."15-\">";
		echo "<AREA SHAPE=RECT COORDS=\"218,106,262,147\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."14-\">";
	        echo "<AREA SHAPE=RECT COORDS=\"215,80,245,103\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."13-\">";
		echo "<AREA SHAPE=RECT COORDS=\"208,54,228,80\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."12-\">";
	        echo "<AREA SHAPE=RECT COORDS=\"194,26,212,60\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."11-\">";
	        echo "<AREA SHAPE=RECT COORDS=\"169,16,190,54\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."10-\">";
	        echo "<AREA SHAPE=RECT COORDS=\"150,9,166,43\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."9-\">";
		echo "<AREA SHAPE=RECT COORDS=\"121,9,143,41\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."8-\">";
		echo "<AREA SHAPE=RECT COORDS=\"100,15,122,49\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."7-\">";
		echo "<AREA SHAPE=RECT COORDS=\"78,24,102,60\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."6-\">";
		echo "<AREA SHAPE=RECT COORDS=\"59,52,85,75\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."5-\">";
		echo "<AREA SHAPE=RECT COORDS=\"43,72,70,99\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."4-\">";
		echo "<AREA SHAPE=RECT COORDS=\"25,104,65,146\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."3-\">";
		echo "<AREA SHAPE=RECT COORDS=\"15,149,55,190\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."2-\">";
		echo "<AREA SHAPE=RECT COORDS=\"8,189,42,227\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."1-\">";
		echo "   </MAP>";
                echo "   <IMG SRC=\"bocaisuperior.jpg\" NAME=\"Imagen2\" ALIGN=LEFT BORDER=0 USEMAP=\"#MAP2\"><BR CLEAR=LEFT>\n";
                echo "   <MAP NAME=\"MAP3\">\n";
                echo "<AREA SHAPE=RECT COORDS=\"247,16,282,45\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."32-\">";
                echo "<AREA SHAPE=RECT COORDS=\"237,48,270,85\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."31-\">";
                echo "<AREA SHAPE=RECT COORDS=\"228,87,263,132\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."30-\">";
                echo "<AREA SHAPE=RECT COORDS=\"216,129,247,158\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."29-\">";
                echo "<AREA SHAPE=RECT COORDS=\"209,157,239,178\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."28-\">";
                echo "<AREA SHAPE=RECT COORDS=\"197,178,222,211\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."27-\">";
                echo "<AREA SHAPE=RECT COORDS=\"176,187,197,227\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."26-\">";
                echo "<AREA SHAPE=RECT COORDS=\"145,192,176,241\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."25-\">";
                echo "<AREA SHAPE=RECT COORDS=\"113,193,142,236\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."24-\">";
                echo "<AREA SHAPE=RECT COORDS=\"91,188,113,227\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."23-\">";
                echo "<AREA SHAPE=RECT COORDS=\"64,177,93,204\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."22-\">";
                echo "<AREA SHAPE=RECT COORDS=\"50,156,80,178\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."21-\">";
                echo "<AREA SHAPE=RECT COORDS=\"37,131,76,152\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."20-\">";
                echo "<AREA SHAPE=RECT COORDS=\"26,85,68,126\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."19-\">";
                echo "<AREA SHAPE=RECT COORDS=\"18,49,59,85\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."18-\">";
                echo "<AREA SHAPE=RECT COORDS=\"12,7,51,43\" HREF=\"revision.php?paciente=$paciente&diente=$diente"."17-\">";
                echo "      </MAP>";
		echo "      <IMG SRC=\"bocainferior.jpg\" NAME=\"Imagen3\" ALIGN=LEFT BORDER=0 USEMAP=\"#MAP3\"><BR CLEAR=LEFT>\n";
		echo "</TD>";
		echo "<TD WIDTH=14%>";
	        echo "	<ALIGN=CENTER> <FONT COLOR=\"#ffff00\">Tratar</FONT>";
	        echo "     <SELECT NAME=\"lbDientes\" SIZE=10 STYLE=\"color: #ffff00; background: #666699\">";
   $link=mysql_connect("127.0.0.1","root","virgen") or
                         die("Error, no se puede abrir la base de datos".mysql_error());
   $db=mysql_select_db("apolonia"); 

   if(!empty($diente))
    {
      $tok=strtok($diente,"-");
      while($tok)
        { 
         $query=mysql_query("select Pieza from Piezas where Indice=$tok") or 
               die("No se pudo encontrar La Pieza : ".mysql_error());
         $rowi=mysql_fetch_object($query); 
         $Pieza=$rowi->Pieza;

          echo "<OPTION>$Pieza</OPTION>\n";
          $tok=strtok("-");
        } 
     } else
          {
           /*   $query=mysql_query("select * from Diagnosticos where Paciente=$paciente") or 
                    die("No se pudo encontrar La Pieza : ".mysql_error());
              $cuenta=0;
              while($rowi=mysql_fetch_object($query))
               {
                  $cuenta=$cuenta+1;
                  $Pieza=$rowi->Pieza;
                  echo "<OPTION>$Pieza</OPTION>\n";
               }
           */
          }
   mysql_close();
   echo "</SELECT><BR>";
   echo "</TD>";
   echo "<TD WIDTH=34%>";
   echo "<P ALIGN=LEFT> <FONT COLOR=\"#ffff00\">Tratamientos</FONT>";

   echo "<INPUT TYPE=\"HIDDEN\" NAME=\"DIENTE\" VALUE=\"$diente\">";
   echo "<INPUT TYPE=\"HIDDEN\" NAME=\"PACIENTE\" VALUE=\"$paciente\">";

   echo "<br><TEXTAREA NAME=\"tbComentario\" ROWS=7 COLS=40 WRAP=SOFT></TEXTAREA></FONT>";
   		echo "<SELECT NAME=marked[] SIZE=10 MULTIPLE STYLE=\"color: #ffff00; background: #666699\">";
      $link=mysql_connect("127.0.0.1","root","virgen") or
                         die("Error, no se puede abrir la base de datos".mysql_error());
      $db=mysql_select_db("apolonia"); 
      $query=mysql_query("select * from Procedimientos order by Nombre") or 
          die("Error en procedimientos : ".mysql_error());
      while($rowi=mysql_fetch_object($query))
       {
          $Nombre=substr($rowi->Nombre,0,40);
          $Codigo=$rowi->Codigo;
          echo "<OPTION>$Codigo)$Nombre</OPTION>\n";
       }
      mysql_close();
echo "</SELECT>";
echo "   </P>";
echo "</TD>";
echo "</TR>";
echo "</TABLE>";
?>
<CENTER>
<INPUT TYPE="HIDDEN" NAME="ACCION" VALUE="UPDATE">
<INPUT TYPE=IMAGE NAME="cmd" SRC="aquaAceptar.jpg">
</CENTER>
</FORM>
<P><BR><BR>
</P>
</BODY>
</HTML>
