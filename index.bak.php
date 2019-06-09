<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
      require("functions/db.php");
?>
<HTML>
<HEAD>
	<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="estilos/estilos.css" />
	<TITLE>Apolonia R2/5</TITLE>
	<META NAME="GENERATOR" CONTENT="OpenOffice.org 1.1.1  (Linux)">
	<META NAME="CREATED" CONTENT="20041005;22240800">
	<META NAME="CHANGED" CONTENT="20041005;23082400">
	<STYLE>
	<!--
		@page { size: 21cm 29.7cm }
	-->
	</STYLE>
<SCRIPT language="JavaScript">
function help(arg)
{
   var x;

   x=arg;
   window.open(x,"Ayuda Apolonia R2/5","toolbar=no");
}

</SCRIPT>
</HEAD>

<BODY LANG="es-ES" BGCOLOR="#666699" DIR="LTR">
<TABLE WIDTH=720px BORDER=0 CELLPADDING=0 CELLSPACING=1 bgcolor="Black">
	<COL WIDTH=38*>
	<COL WIDTH=109*>
	<COL WIDTH=109*>
	<TR>
		<TD ROWSPAN=3 WIDTH=15% bgcolor="#c0c0c0">
			<P ALIGN=CENTER><IMG SRC="img/staapolonia.jpg" NAME="Imagen1" ALIGN=BOTTOM WIDTH=111 HEIGHT=183 BORDER=0></P>
		</TD>
		<TD COLSPAN=2 WIDTH=85% bgcolor="#c0c0c0" align="right">
			<FONT COLOR="#cc0000">Powered by <FONT FACE="Arial"><I><B>Apolonia R2/5</B></I>
		</TD>
	</TR>
	<TR>
		<TD COLSPAN=2 WIDTH=85% bgcolor="White" align="center">
			<?php
			   echo "<font size=4>C.A.D.I</font>";
			?>

		</TD>
	</TR>
	<TR>
		<TD colspan=2 align="left" bgcolor="White">
		<form action="logoncentral.php" method=post>
		<Table border=0 width=100%>
			<TR>
				<TD>&nbsp; Usuario
				</TD>
				<TD>
				   <input type="TEXT" name="usuario" value="" id="usr" length=40 maxlength=49>
				</TD>
			</TR>
			<TR>
				<TD>&nbsp; Clave
				</TD>
				<TD>
				   <input type="password" name="clave" id="paswd" value="" length=40 maxlength=20>
				</TD>
			</TR>
			<TR>
				<TD>&nbsp; Ingresar a 
				</TD>
				<TD>
					<select name="sucursal" id="sucursal">
					<?php
						$db = conectar();
						$q = "select Sucursal from Consultorios group by Sucursal order by Sucursal";
						$query = query($q);
						while($reg=fetch($query))
						{
							$s = $reg->Sucursal;
							if($s == $coisucursal)
								$sel="selected";
							else
								$sel="";
		       					echo "<option value='$s' $sel>$s</option>";
						}
					?>
					</select>
				</TD>
			</TR>
			<TR>
				<TD colspan=2 align="center">
				    <input type="submit" name="comando" value="Ingresar">
				</TD>
			</TR>
		</table>
		</form>		
			<UL>
				<button onclick="help('/apoloniaR2help/login.html')"><img src="img/help.png" align="bottom"> Ayuda
				</button>
			</UL>
		</TD>
	<TR>
		<TD  colspan=3 align="center" bgcolor="#c0c0c0">	
			<FONT SIZE=1>Copyright &copy; 1999 - 2005  <a href="http://www.kcreativa.com"><font size=1>Ingenier&iacute;a kCreativa</font></a><BR>Todos los derechos reservados</FONT>		
		</TD>
	</TR>
</TABLE>
</BODY>
</HTML>
