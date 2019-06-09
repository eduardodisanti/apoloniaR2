<?php
    if(!empty($paciente))
           setcookie("apoloniaPaciente",$paciente);
    if(!empty($diente))
           setcookie("apoloniaDiente",$diente);

    include("funciones.php");
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

<FORM NAME="Standard" action="episodio.php4" method="post">
<HR>
<FONT COLOR="#800000"><FONT FACE="Arial, sans-serif"><FONT SIZE=4>          Ingresar un Eposidio a la historia</FONT></FONT></FONT>
<FONT SIZE=4>Paciente :
<?php

    if($paciente!=0)
        $apoloniaPaciente=$paciente;

    if(empty($apoloniaPaciente))
       $apoloniaPaciente=$paciente;

    if(!empty($apoloniaPaciente))
    {
      $link=mysql_connect("127.0.0.1","root","virgen") or
                         die("Error, no se puede abrir la base de datos".mysql_error());
      $db=mysql_select_db("apolonia");

    if($COMENTANDO=="SI")
      {
         $coment=mysql_query("delete from Comentarios where Paciente=$apoloniaPaciente");
         $coment=mysql_query("insert into Comentarios values($apoloniaPaciente, '$comentario')");
      } 

      $query=mysql_query("select * from Pacientes where Cedula=$apoloniaPaciente") or 
          die("No se pudo encontrar el paciente $apoloniaPaciente : ".mysql_error());
      $rowi=mysql_fetch_object($query);
      $Nombre=$rowi->Nombre;
      $Seguro=$rowi->Seguro;
      $Paga=$rowi->Paga;
      echo $Nombre." (".$Seguro.") $apoloniaPaciente";
      if($Paga=="S")
          echo " <b>debe abonar</b>\n";

    // *** Me fijo que se haya confirmado para lo cual veo si aun tiene la falta
      $fechaHoy=date("Y-m-d");
      $query = mysql_query("select * from Horarios where Fecha='$fechaHoy' and Paciente=$apoloniaPaciente");
      $rowi=mysql_fetch_object($query);
      $vino=$rowi->Vino;
      $proced=$rowi->Procedimiento;
   /* ****************
      Plan ortodoncia, sacarlo cuando este armado la ort fija
      ****************
   */
      if(empty($vino))
        {
            $planort=mysql_query("select * from PlanOrtodoncia where Paciente=$apoloniaPaciente");
            $preg=mysql_fetch_object($planort);
            $pomedico=$preg->Medico;
            if(!empty($pomedico))
                $vino="S";
            else
              {
                $vino="N";
              }

        }
         $fechaHoy=date("Y-m-d");
         $planort=mysql_query("select * from Emergencias where Paciente=$apoloniaPaciente and Fecha='$fechaHoy'");
         $preg=mysql_fetch_object($planort);
         $popac=$preg->Paciente;
         if(!empty($popac))
                   $vino="S";
         else
          {
            $planort=mysql_query("select * from Autorizados where Cedula=$apoloniaPaciente and Fecha='$fechaHoy'");
            $preg=mysql_fetch_object($planort);
            $popac=$preg->Cedula;
            if(!empty($popac))
              $vino="S";
          }
       

      if($vino!="S")
        {
           $msg="<br>El paciente no confirmo asistencia<br>"; 
           $msg=$msg."Fecha: $consFecha<br>";
           $msg=$msg."Pulse <a href=\"#\" \"document.back()\">aqui</a> para volver o <a href='conshist.php3?paciente=$apoloniaPaciente' target='historia'> aqui </a> para consultar su historia<hr>";
            //die($msg);
        }

    } else 
         die("Error");
      mysql_close();
?>
<HR>
<?php
   if($ACCION=="UPDATE")
    {
      echo "El paciente es $apoloniaPaciente<br>";
      $link=mysql_connect("127.0.0.1","root","virgen") or
                         die("Error, no se puede abrir la base de datos".mysql_error());
      $db=mysql_select_db("apolonia"); 
 
      if(empty($diente))
            $diente="999-";
 
      if(!empty($apoloniaDiente))
        {
         echo "<br>$apoloniaDiente<br>";
         $tok=strtok($apoloniaDiente,"-");
         while($tok)
           { 
            echo "$tok<BR>";
            $query=mysql_query("select Pieza from Piezas where Indice=$tok") or 
                 die("No se pudo encontrar La Pieza : ".mysql_error());
            $rowi=mysql_fetch_object($query); 
            $Pieza=$rowi->Pieza;
            echo "Actualizando Pieza: $Pieza";
            $hora=strtotime("now");
            $fecha=date("Ymd");
            echo(" OK!<BR>");
            reset($marked);
              if(is_array($marked))
               {  while(list($dummy,$Proci)=each($marked))
                  {
                     list($Proc,$dumito,$Nom)=split(')',$Proci);                 
                     echo "$Proc -$Nom-$dumito";
                     $query2=mysql_query("insert into Episodios values($apoloniaPaciente,'$fecha', $Pieza, $Proc, '$hora','$tbComentario',$coifuncionario)") or  
                            die("No se puede insertar, error ".mysql_error().
                                 " insert into Episodios values($apoloniaPaciente,'$fecha',$Pieza,$Proc,'$hora','$tbComentario')");
                      if($TERMINADO)   // *********** PROCEDIMIENTO TERMINADO ***************
                       {
                         $query3=mysql_query("delete from ParaHacer where Paciente=$apoloniaPaciente and Pieza=$Pieza and Procedimiento=$Proc")
                                    or die("No se pudo actualizar Lista de Pendientes".mysql_error());

                         echo "delete from ParaHacer where Paciente=$apoloniaPaciente and Pieza=$Pieza and Procedimiento=$Proc";
                         $tienepend = tiene_pendientes($apoloniaPaciente);
                         echo "pendientes es $tienepend<br>";
                         if(!$tienepend)
                           {
                              agregarEpisodioAlta($apoloniaPaciente, $coifuncionario);
                           }
                       }
                     $query=mysql_query("delete from Asistencia where Paciente=$apoloniaPaciente");
                   }
               }
            $tok=strtok("-");
           } 
        }

      echo("Actualizado correctamente <A HREF=episodio.php4?paciente=$apoloniaPaciente>Pulse aqui para volver</A>");
      mysql_close();
      echo "<hr><h2><center><font color=\"#FFFFFF\">Comentarios para Recepcion y Att. Telefonica</font></center></h2>";
      echo "<center><textarea name=\"comentario\" cols=60 rows=5></textarea><br>";
      echo "<input type=\"HIDDEN\" name=\"COMENTANDO\" value=\"SI\">";
      echo "<input type=\"submit\" value=\"Actualizar\" name=\"xx\"></center>";
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
                     echo "<AREA SHAPE=RECT COORDS=\"30,136,53,160\" HREF=\"episodio.php4?diente=$diente"."52-\">\n";
                     echo "<AREA SHAPE=RECT COORDS=\"40,165,57,187\" HREF=\"episodio.php4?diente=$diente"."51-\">\n";
                     echo "<AREA SHAPE=RECT COORDS=\"57,187,70,203\" HREF=\"episodio.php4?diente=$diente"."50-\">\n";
                     echo "<AREA SHAPE=RECT COORDS=\"70,198,82,213\" HREF=\"episodio.php4?diente=$diente"."49-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"82,202,96,218\" HREF=\"episodio.php4?diente=$diente"."48-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"96,200,110,218\" HREF=\"episodio.php4?diente=$diente"."47-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"113,198,126,212\" HREF=\"episodio.php4?diente=$diente"."46-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"126,185,141,200\" HREF=\"episodio.php4?diente=$diente"."45-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"137,161,156,187\" HREF=\"episodio.php4?diente=$diente"."44-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"137,134,166,161\" HREF=\"episodio.php4?diente=$diente"."43-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"141,65,168,96\" HREF=\"episodio.php4?diente=$diente"."42-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"139,52,160,65\" HREF=\"episodio.php4?diente=$diente"."41-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"129,37,146,52\" HREF=\"episodio.php4?diente=$diente"."40-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"116,23,133,37\" HREF=\"episodio.php4?diente=$diente"."39-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"97,16,116,36\" HREF=\"episodio.php4?diente=$diente"."38-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"80,16,97,36\" HREF=\"episodio.php4?diente=$diente"."37-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"62,23,79,39\" HREF=\"episodio.php4?diente=$diente"."36-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"50,37,66,52\" HREF=\"episodio.php4?diente=$diente"."35-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"40,51,60,72\" HREF=\"episodio.php4?diente=$diente"."34-\">";
                     echo "<AREA SHAPE=RECT COORDS=\"29,72,60,100\" HREF=\"episodio.php4?diente=$diente"."33-\">";
                  ?>
                  </MAP>
                  <IMG SRC="bocatemporal.jpg" NAME="Imagen1" ALIGN=LEFT WIDTH=196 HEIGHT=265 BORDER=0 USEMAP="#MAP1"><BR CLEAR=LEFT><BR>
                  <?php echo "<A HREF=\"conshist.php4?paciente=$apoloniaPaciente\" target=\"_historia\">Ver historia</A><BR>"; 
                     echo "<A HREF=\"episodio.php4?paciente=$apoloniaPaciente&diente=$diente"."999-\">Toda la boca</A><BR>";
                     echo "<A HREF=\"pendientes.php4?paciente=$apoloniaPaciente\" target=\"_pendientes\">Ver pendientes</A><BR>";
                     echo "<A HREF=\"episodio.html\">Otro Paciente</A>";
                  ?>
		</TD>
		<TD WIDTH=25%>
                  <MAP NAME="MAP2">
              <?php
	        
                echo "<AREA SHAPE=RECT COORDS=\"242,194,273,229\" HREF=\"episodio.php4?diente=$diente"."16-\">";
	        echo "<AREA SHAPE=RECT COORDS=\"231,153,269,191\" HREF=\"episodio.php4?diente=$diente"."15-\">";
		echo "<AREA SHAPE=RECT COORDS=\"218,106,262,147\" HREF=\"episodio.php4?diente=$diente"."14-\">";
	        echo "<AREA SHAPE=RECT COORDS=\"215,80,245,103\" HREF=\"episodio.php4?diente=$diente"."13-\">";
		echo "<AREA SHAPE=RECT COORDS=\"208,54,228,80\" HREF=\"episodio.php4?diente=$diente"."12-\">";
	        echo "<AREA SHAPE=RECT COORDS=\"194,26,212,60\" HREF=\"episodio.php4?diente=$diente"."11-\">";
	        echo "<AREA SHAPE=RECT COORDS=\"169,16,190,54\" HREF=\"episodio.php4?diente=$diente"."10-\">";
	        echo "<AREA SHAPE=RECT COORDS=\"150,9,166,43\" HREF=\"episodio.php4?diente=$diente"."9-\">";
		echo "<AREA SHAPE=RECT COORDS=\"121,9,143,41\" HREF=\"episodio.php4?diente=$diente"."8-\">";
		echo "<AREA SHAPE=RECT COORDS=\"100,15,122,49\" HREF=\"episodio.php4?diente=$diente"."7-\">";
		echo "<AREA SHAPE=RECT COORDS=\"78,24,102,60\" HREF=\"episodio.php4?diente=$diente"."6-\">";
		echo "<AREA SHAPE=RECT COORDS=\"59,52,85,75\" HREF=\"episodio.php4?diente=$diente"."5-\">";
		echo "<AREA SHAPE=RECT COORDS=\"43,72,70,99\" HREF=\"episodio.php4?diente=$diente"."4-\">";
		echo "<AREA SHAPE=RECT COORDS=\"25,104,65,146\" HREF=\"episodio.php4?diente=$diente"."3-\">";
		echo "<AREA SHAPE=RECT COORDS=\"15,149,55,190\" HREF=\"episodio.php4?diente=$diente"."2-\">";
		echo "<AREA SHAPE=RECT COORDS=\"8,189,42,227\" HREF=\"episodio.php4?diente=$diente"."1-\">";
              ?>
		   </MAP>
                   <IMG SRC="bocaisuperior.jpg" NAME="Imagen2" ALIGN=LEFT BORDER=0 USEMAP="#MAP2"><BR CLEAR=LEFT>
                      <MAP NAME="MAP3">
               <?php
                echo "<AREA SHAPE=RECT COORDS=\"247,16,282,45\" HREF=\"episodio.php4?diente=$diente"."32-\">";
                echo "<AREA SHAPE=RECT COORDS=\"237,48,270,85\" HREF=\"episodio.php4?diente=$diente"."31-\">";
                echo "<AREA SHAPE=RECT COORDS=\"228,87,263,132\" HREF=\"episodio.php4?diente=$diente"."30-\">";
                echo "<AREA SHAPE=RECT COORDS=\"216,129,247,158\" HREF=\"episodio.php4?diente=$diente"."29-\">";
                echo "<AREA SHAPE=RECT COORDS=\"209,157,239,178\" HREF=\"episodio.php4?diente=$diente"."28-\">";
                echo "<AREA SHAPE=RECT COORDS=\"197,178,222,211\" HREF=\"episodio.php4?diente=$diente"."27-\">";
                echo "<AREA SHAPE=RECT COORDS=\"176,187,197,227\" HREF=\"episodio.php4?diente=$diente"."26-\">";
                echo "<AREA SHAPE=RECT COORDS=\"145,192,176,241\" HREF=\"episodio.php4?diente=$diente"."25-\">";
                echo "<AREA SHAPE=RECT COORDS=\"113,193,142,236\" HREF=\"episodio.php4?diente=$diente"."24-\">";
                echo "<AREA SHAPE=RECT COORDS=\"91,188,113,227\" HREF=\"episodio.php4?diente=$diente"."23-\">";
                echo "<AREA SHAPE=RECT COORDS=\"64,177,93,204\" HREF=\"episodio.php4?diente=$diente"."22-\">";
                echo "<AREA SHAPE=RECT COORDS=\"50,156,80,178\" HREF=\"episodio.php4?diente=$diente"."21-\">";
                echo "<AREA SHAPE=RECT COORDS=\"37,131,76,152\" HREF=\"episodio.php4?diente=$diente"."20-\">";
                echo "<AREA SHAPE=RECT COORDS=\"26,85,68,126\" HREF=\"episodio.php4?diente=$diente"."19-\">";
                echo "<AREA SHAPE=RECT COORDS=\"18,49,59,85\" HREF=\"episodio.php4?diente=$diente"."18-\">";
                echo "<AREA SHAPE=RECT COORDS=\"12,7,51,43\" HREF=\"episodio.php4?diente=$diente"."17-\">";
               ?>
                      </MAP>
		      <IMG SRC="bocainferior.jpg" NAME="Imagen3" ALIGN=LEFT BORDER=0 USEMAP="#MAP3"><BR CLEAR=LEFT>
		</TD>
		<TD WIDTH=14%>
			<ALIGN=CENTER> <FONT COLOR="#ffff00">Pieza</FONT>
				<SELECT NAME="lbDientes" SIZE=10 STYLE="color: #ffff00; background: #666699">
<?php
//      echo "<INPUT TYPE=\"HIDDEN\" NAME=\"DIENTE\" VALUE=\"$diente\">";
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
?>
                        </SELECT><BR>
		</TD>
		<TD WIDTH=34%>
			<P ALIGN=LEFT> <FONT COLOR="#ffff00">Descripcion del procedimiento Actual</FONT>
                <TEXTAREA NAME="tbComentario" ROWS=12 COLS=40 WRAP=SOFT></TEXTAREA></FONT>
<?php
   		echo "<SELECT NAME=marked[] SIZE=12 MULTIPLE STYLE=\"color: #ffff00; background: #666699\">";
      $link=mysql_connect("127.0.0.1","root","virgen") or
                         die("Error, no se puede abrir la base de datos".mysql_error());
      $db=mysql_select_db("apolonia"); 
      $query=mysql_query("select * from Procedimientos order by Nombre") or 
          die("Error en procedimientos : ".mysql_error());
      while($rowi=mysql_fetch_object($query))
       {
          $Nombre=$rowi->Nombre;
          $Codigo=$rowi->Codigo;
          echo "<OPTION>$Codigo)$Nombre</OPTION>\n";
       }
      mysql_close();
      echo "</SELECT>";
?>                
                         </P>
		</TD>
	</TR>
        <TR>
                <TD>&nbsp</TD><TD>&nbsp</TD><TD>&nbsp</TD>
                <TD>                  
                       <INPUT TYPE="CHECKBOX" NAME="TERMINADO" VALUE="FALSE"> Procedimiento Terminado
                </TD>
        </TR>
</TABLE>
<CENTER>
<INPUT TYPE="HIDDEN" NAME="ACCION" VALUE="UPDATE">
<INPUT TYPE=IMAGE NAME="cmd" SRC="aquaAceptar.jpg">
</CENTER>
</FORM>
<P><BR><BR>
</P>
</BODY>
</HTML>
