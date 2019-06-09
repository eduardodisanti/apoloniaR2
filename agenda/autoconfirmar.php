<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="CONTENT-TYPE" content="text/html; charset=iso-8859-1">
  <title>Autogestion - Confirmar</title>


<style type="text/css">
     A:link  {color:#9A3D3F}
     A:visited {color:#9A3D3F}
     A:hover {color: #C44487}

     BODY{font-family: 'Lucida Sans',serif}
</style>

<script>

function welcome() {
	
	txtCedula = document.getElementById("ci");
	txtCedula.focus();}

</script>
</head>

<body bgcolor="#ffffff" onload='welcome()'>
<table border=0 width='99%'>
<tr>
	<td width='128px'><img src='../img/logo.png'></td>
	<td align='center'><font size='48px'>Confirme su asistencia</font><br><font size='6' color='#ff0000'>sin hacer cola</font></td>
	<td width='160px' valign='middle' align='right'>
	<!-- Start JavaScript Clock Code --><div id="js_clock"><script language="javascript">function js_clock(){var clock_time = new Date();var clock_hours = clock_time.getHours();var clock_minutes = clock_time.getMinutes();var clock_seconds = clock_time.getSeconds();var clock_suffix = "AM";if (clock_hours > 11){clock_suffix = "PM";clock_hours = clock_hours - 12;}if (clock_hours == 0){clock_hours = 12;}if (clock_hours < 10){clock_hours = "0" + clock_hours;}if (clock_minutes < 10){clock_minutes = "0" + clock_minutes;}if (clock_seconds < 10){clock_seconds = "0" + clock_seconds;}var clock_div = document.getElementById('js_clock');clock_div.innerHTML = "<font size=5>"+clock_hours + ":" + clock_minutes + ":" + clock_seconds + " " +"</font>"+ clock_suffix;setTimeout("js_clock()", 1000);}js_clock();</script></div><!-- End JavaScript Clock Code -->
	</td>
</tr>
<tr>
	<td align='center' colspan=3><font size='6'>Digite su c&eacute;dula de identidad y pulse Enter</font><br></td>
</tr>

</table>
<?php

    echo "<form action='autoconfirmar.do.php' method=post>\n";
    echo "<center>";
    echo "<input type=\"TEXT\" id='ci' name=\"ci\" value=\"\" size=8 maxlength=8 style='font-size:48pt;align:right;border-color:#ff0000;border-width:3px;padding:5px'>";
    echo "</center>";
    echo "<br><center><font color='#ff0000' size='5'>Por favor no digite ni guiones ni digito verificador</font></center>";

   echo "</form>";
?>
</form>
</body>
</html>

