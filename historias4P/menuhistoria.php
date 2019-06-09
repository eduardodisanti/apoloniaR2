
<style>
div.menu {
			position: relative;
			top: 0px;
			left: 0px;
}

a.menu {

			text-align: left;
			font-size: 12px; 
			text-decoration: none;
			display:block;
			color: #ffffff;
			background: #660000;
}

a.menu:hover {  cursor: pointer;
				background: #990000;
				text-align: rigth;
				font-size: 12px;
			  }			  
</style>

<?php
function mostrarMenuHistoria($paciente) {

echo "<div id='nav' class='menu'>";
	echo "<table border=0 cellspacing=1 cellpadding=0 width=100px>";
	echo "<tr><td align=center><a class='menu' onclick='mostrarHistoria($paciente)'><img src='../img/historias.png' border=0>Historia</a></td></tr>";
	echo "<tr><td align=center><a class='menu' onclick='mostrarAntecedentes($paciente)'><img src='../img/antecedentes.png' border=0>Antecedentes</a></td></tr>";
	/* echo "<tr><td align=center><a class='menu' onclick='mostrarPendientes($paciente)'><img src='../img/pendientes.png' border=0>Pendientes</a></td></tr>";*/	
	echo "<tr><td align=center><a class='menu' onclick='mostrarDiagnosticos($paciente)'><img src='../img/diagnosticos.png' border=0>Diagnosticos</a></td></tr>";

	echo "<tr><td align=center><a class='menu' onclick='pedirSoporte($nombre)'><img src='../img/txt2.png' border=0>Soporte tec.</a></td></tr>";
//	echo "<tr><td align=center><a class='menu' onclick='abrirHermes($nombre, $clave)'><img src='../img/make.png' border=0>Hermes</a></td></tr>";
	echo "<tr><td align=center><a class='menu' onclick='abrirEmail($nombre)'><img src='../img/mail.png' border=0>Email</a></td></tr>";

	echo "<tr><td align=left>";
	echo "<a class='menu' onclick='cerrarPanel()'><img src='../img/back.png' border=0></a>";
	echo "</td></tr>";	

	echo "</table>";	
echo "</div>";
}
?>
