<?php
     setcookie("apoloniaPaciente",0);
     setcookie("apoloniaDiente","");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
<HEAD>
	<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=iso-8859-1">
	<TITLE></TITLE>
	<META NAME="GENERATOR" CONTENT="StarOffice/5.2 (Win32)">
	<META NAME="AUTHOR" CONTENT="Eduardo Di Santi">
	<META NAME="CREATED" CONTENT="20010607;8563858">
	<META NAME="CHANGEDBY" CONTENT="Eduardo Di Santi">
	<META NAME="CHANGED" CONTENT="20010607;9184619">
</HEAD>
<BODY BGCOLOR="#9999cc">

<P ALIGN=CENTER><FONT COLOR="#ffff99"><FONT SIZE=+1 >Ingresar un episodio a la Historia
</FONT></FONT>
</P>
<HR>
<FORM NAME="Standard" ACTION="hojahistoria.php" target="_historia">
	<TABLE WIDTH=100% BORDER=0 CELLPADDING=4 CELLSPACING=0>
		<COL WIDTH=56*>
		<COL WIDTH=91*>
		<COL WIDTH=52*>
		<COL WIDTH=57*>
		<THEAD>
			<TR VALIGN=TOP>
				<TD WIDTH=22%>
					<P><BR>
					</P>
				</TD>
				<TH WIDTH=35%>
					<P><FONT SIZE=5>C&eacute;dula del Paciente</FONT></P>
				</TH>
				<TH WIDTH=20%>
					<P><INPUT TYPE=TEXT NAME="paciente" SIZE=22 MAXLENGTH=9></P>
				</TH>
				<TH WIDTH=22%>
					<P><BR>
					</P>
				</TH>
			</TR>
		</THEAD>
		<TBODY>
			<TR VALIGN=TOP>
				<TD WIDTH=22%>
					<P><BR>
					</P>
				</TD>
				<TD WIDTH=35%>
					<P><BR>
					</P>
				</TD>
				<TD WIDTH=20%>
					<P><BR>
					</P>
				</TD>
				<TD WIDTH=22%>
					<P><BR>
					</P>
				</TD>
			</TR>
		</TBODY>
	</TABLE>
	<DIV ALIGN=CENTER>
		<P><FONT COLOR="#ffff99"><FONT SIZE=7 STYLE="font-size: 32pt"><FONT SIZE=1 STYLE="font-size: 8pt">
		<INPUT TYPE=submit NAME="Aceptar"></FONT></FONT></FONT></P>
	</DIV>
	
	<?php

			echo "<input type=hidden name='medico' value='$medico'>";
	?>
</FORM>
<P ALIGN=CENTER><BR><BR>
</P>
<P ALIGN=RIGHT><BR><BR>
</P>
</BODY>
</HTML>
