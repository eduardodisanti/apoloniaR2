<?php

if(empty($coiusuario)) {

    session_start();
    $coiusuario= $_SESSION['coiusuario'];
}

?>

    <script type="text/javscript">
    /* preload images */
    var arrow1 = new Image(4, 7);
    arrow1.src = "menu/images/arrow1.gif";
    var arrow2 = new Image(4, 7);
    arrow2.src = "menu/images/arrow2.gif";
    </script>

    <div id="bar">
        
        <table cellspacing="0" cellpadding="0" id="menu1" class="XulMenu">
        <tr>
            <td>
                <a class="button" href="javascript:void(0)">Sistema</a>
                <div class="section">
                    <a class="item" href="index.php">Inicio</a>
                    <a class="item" href="desconectar.php">Cerrar</a>
                </div>
            </td>
            <td>
                <a class="button" href="javascript:void(0)">Citas</a>
                <div class="section">
                        <a class="item" href="index.php?contenido=revision.php">Anotar Revision</a>
                        <a class="item" href="index.php?contenido=anotar.php">Anotar Consulta</a>
                        <a class="item" href="index.php?contenido=borrar.php">Anular</a>
                        <a class="item" href="index.php?contenido=confirmar.php">Confirmar</a>
                        <a class="item" href="index.php?contenido=listapac.php">Consutar</a>
                        <a class="item" href="index.php?contenido=consbor.php">Historia de borrados</a>
                        <a class="item" href="index.php?contenido=borrfal.php">Borrar faltas</a>
                </div>
            </td>
            <td>
                <a class="button" href="javascript:void(0)">Pacientes</a>
                <div class="section">
                            <a class="item" href="index.php?contenido=padron.php">Consultar el padron</a>
                            <a class="item" href="index.php?contenido=anotar.php?aut=1">Autorizaciones</a>
                            <a class="item" href="index.php?contenido=emergencia.php">Emergencias</a>
			    <a class="item" href="index.php?contenido=imppres.php">Imprimir presupuesto</a>
                </div>
            </td>
            <td>
                <a class="button" href="javascript:void(0)">Ortodoncia Fija</a>
                <div class="section">
                            <a class="item" href="index.php?contenido=../admin/caportodoncia.php">Capacidad ortodoncia</a>
                            <a class="item" href="index.php?contenido=../admin/planortod.php">Plan de asistencia</a>
			    <a class="item" href="index.php?contenido=../admin/listort.php">Capacidad libre</a>
			    <a class="item" href="index.php?contenido=../informes/socios/deudasof.php">TT-ORF-01 Informe general de ortodoncia fija</a>
                </div>
            </td>
	    <td>
                <a class="button" href="javascript:void(0)">Pedidos de stock</a>
                <div class="section">
                            <a class="item" href="index.php?contenido=../stock/pedido.php?almacen=0">Pedido mensual</a>
                            <a class="item" href="index.php?contenido=../stock/recmerc.php?almacen=0">Recibir pedidos</a>
                            <a class="item" href="index.php?contenido=../stock/inventariosuc.php">Inventario de sucursal</a>
                </div>
           </td>
           <td>
	        <a class="button" href="javascript:void(0)">Informes</a>
	        <div class="section">
	                    <a class="item" href="index.php?contenido=../informes/laboratorios/listxlab.php">Listados de trabajos en el dia</a>
	                    <a class="item" href="index.php?contenido=../informes/venctrab.php?cmd=listar">Vencimiento de trabajos de lab.</a>
			  <a class="item" href="index.php?contenido=../informes/venctrabxpac.php?cmd=listar">Trabajos de lab x cedula</a>
			  <a class="item" href="index.php?contenido=../informes/estadoTrabajos.php">Trabajos de laboratorio</a>
			  <a class="item" href="index.php?contenido=../informes/resumenlab.php">Resumen diario de trabajos</a>
			  <a class="item" href="index.php?contenido=../informes/venctrabxmed.php">Consultas con trabajos de laboratorio</a>
			  <a class="item" href="index.php?contenido=../informes/laboratorios/tt-eal-01.php">TT-EAL-01</a>
			  <a class="item" href="index.php?contenido=../informes/laboratorios/tt-eal-03.php">TT-EAL-03</a>
			  <a class="item" href="index.php?contenido=../admin/tt-ait-01.php">TT-AIT-01</a>
			  <a class="item" href="index.php?contenido=../informes/socios/listaseguros.php">TT-AIT-02 Seguros</a>
			  <a class="item" href="index.php?contenido=../informes/emergencia/tablaurg.php">Tabla de urgencias</a>

	        </div>
           </td>

            <td>
                <a class="button" href="javascript:void(0)">Ayuda</a>
                <div class="section">
                    <a class="item" href="../manuales/calidad.php">Manual de Calidad</a>
                    <a class="item" href="../manuales/sistema.php">Manual del sistema</a>
                    <a class="item" href="index.php?contenido=../bugdb/reportar.php">Reportar errores</a>
		    <a class="item" href="http://hermes.kcreativa.com/script/solicitud.php?Hcliente=111&quien=C&Husuario=<?php echo $coiusuario; ?>" target="_blank">Pedir soporte tecnico</a>
                </div>
            </td>
            <td width=200px>
                &nbsp;
            </td>    
            <td>
                <a class="button" href="javascript:history.go(-1)"><img src="../img/back.png" border=0 align=middle> Atras</a>
            </td>
            <td>
                <a class="button" href="index.php"><img src="../img/gohome.png" border=0 align=middle>Inicio</a>
            </td>	    
            <td>
                <a class="button" href="javascript:contenido.location.reload()"><img src="../img/reload.png" border=0 align=middle>Actualizar</a>
            </td>	    
            <td>
                <a class="button" href="javascript:contenido.window.print()"><img src="../img/fileprint.png" border=0 align=middle>Imprimir</a>
            </td>
	    <td>
	        <a class="button" href="http://www.cadi.com.uy/cgi-bin/openwebmail/openwebmail.pl" target="_email"><img src="../img/mail.png" border="0" align=middle width=24px >email</a>
            </td>
            <td>
                <a class="button" href="../logoncentral.php?situacion=yalogeado#"><img src="../img/exit.png" border=0 align=middle>Salir</a>
            </td>	                    
	</tr>
        </table>
    </div>

    <script type="text/javascript">
    var menu1 = new XulMenu("menu1");
    menu1.arrow1 = "images/arrow1.gif";
    menu1.arrow2 = "images/arrow2.gif";
    menu1.init();
    </script>
