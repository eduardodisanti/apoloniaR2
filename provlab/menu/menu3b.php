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
                    <a class="item" href="../desconectar.php">Cerrar</a>
                </div>
            </td>
            <td>
               <a class="button" href="javascript:void(0)">Laboratorio</a>
               <div class="section">
                         <a class="item" href="index.php?contenido=../informes/pendalab.php?cmd=bajar">Pendientes de Laboratorio</a>
               </div>
            </td>
            <td>
                <a class="button" href="javascript:void(0)">Ayuda</a>
                <div class="section">
		    <a class="item" href="http://hermes.kcreativa.com/script/solicitud.php?cliente=111&quien=C&Husuario=<?php echo $coiusuario; ?>" target="_blank">Pedir soporte tecnico</a>
                </div>
            </td>
            <td width=200px>
                &nbsp;
            </td>    
            <td>
                <a class="button" href="javascript:history.go(-1)"><img src="/apoloniaR2/img/back.png" border=0 align=middle> Atras</a>
            </td>
            <td>
                <a class="button" href="index.php"><img src="/apoloniaR2/img/gohome.png" border=0 align=middle>Inicio</a>
            </td>	    
            <td>
                <a class="button" href="javascript:contenido.location.reload()"><img src="/apoloniaR2/img/reload.png" border=0 align=middle>Recargar</a>
            </td>	    

            <td>
                <a class="button" href="javascript:contenido.window.print()"><img src="/apoloniaR2/img/fileprint.png" border=0 align=middle>Imprimir</a>
            </td>
            <td>
                <a class="button" href="../logoncentral.php?situacion=yalogeado#"><img src="/apoloniaR2/img/exit.png" border=0 align=middle>Salir</a>
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
