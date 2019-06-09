    <script type="text/javscript">
    /* preload images */
    var arrow1 = new Image(4, 7);
    arrow1.src = "menu/images/arrow1.gif";
    var arrow2 = new Image(4, 7);
    arrow2.src = "menu/images/arrow2.gif";
    </script>

    <div id="menu">       
        <table cellspacing="0" cellpadding="0" id="menu1" class="XulMenu">
        <tr>
            <td>
                <a class="button" href="javascript:void(0)">Sistema</a>
                <div class="section">
                    <a class="item" href="stock.php?cmd=articulos">Inicio</a>
                    <a class="item" href="desconectar.php">Cerrar</a>
                </div>
            </td>
            <td>
                <a class="button" href="javascript:void(0)">Movimientos de stock</a>
                <div class="section">
                        <a class="item" href="stock.php?cmd=ingremman">Transferencias</a>                
                        <a class="item" href="stock.php?cmd=remitos">Remitos</a>
                        <a class="item" href="stock.php?cmd=facturas">Facturas</a>
                        <a class="item" href="stock.php?cmd=ajustes">Ajustes de stock</a>
			<a class="item" href="stock.php?cmd=ingmanstck">Ingreso manual de stock</a>
			<a class="item" href="stock.php?cmd=recmerc">Recepcion de pedidos de almacenes</a>
                </div>
            </td>
            <td>
                <a class="button" href="javascript:void(0)">Mantenimiento</a>
                <div class="section">
                            <a class="item" href="stock.php?cmd=articulos">Articulos</a>
                            <a class="item" href="stock.php?cmd=almacenes">Almacenes</a>
                            <a class="item" href="stock.php?cmd=familias">Familias</a>
                            <a class="item" href="stock.php?cmd=proveedores">Proveedores</a>
                            <a class="item" href="hermes/update.php">Actualizar el sistema</a>
                            <a class="item" href="stock.php?cmd=informes">Informes</a>
			    <a class="item" href="stock.php?cmd=inglote">Ingreso diferido de lotes</a>^M
                </div>
            </td>
	    <td>
	    <a class="button" href="javascript:void(0)">Compras</a>
	        <div class="section">
	                    <a class="item" href="stock.php?cmd=ordencompra">Ingreso de ordenes de compra</a>
	                    <a class="item" href="stock.php?cmd=editaroc">Editar ordenes de compra</a>
	                    <a class="item" href="stock.php?cmd=generarproforma">Generar proforma</a>
	    </td>
	    <td>
	                <a class="button" href="javascript:void(0)">Pedidos</a>
			                <div class="section">
					                            <a class="item" href="stock.php?cmd=pedidos">Manejo de pedidos</a>
								                                <a class="item" href="stock.php?cmd=pedido">Ver pedidos en proceso</a>
												                            <a class="item" href="stock.php?cmd=actpedido">Actualizar pedidos de una sucursal</a>
															                                <a class="item" href="stock.php?cmd=cierropedido">Cierre mensual de pedidos</a>
																			            </td>
            <td>
                <a class="button" href="javascript:void(0)">Consultas</a>
                <div class="section">
                            <a class="item" href="stock.php?cmd=fichastck">Ficha de stock</a>
			    <a class="item" href="stock.php?cmd=listavenc">Lista de vencimiento</a>
			    <a class="item" href="stock.php?cmd=listinv">Lista para inventario</a>
			    <a class="item" href="stock.php?cmd=lisrepo">Lista de reposicion</a>
			    <a class="item" href="stock.php?cmd=inventario">Inventario</a>
                            <a class="item" href="stock.php?cmd=invxalm">Inventario x almacen</a>
			    <a class="item" href="stock.php?cmd=invxfam">Inventario x familia</a>
                </div>
            </td>
            <td>
                <a class="button" href="javascript:void(0)">Ayuda</a>
                <div class="section">
                    <a class="item" href="manuales/sistema.php">Manual del sistema</a>
                    <a class="item" href="hermes/bug.php">Reportar errores</a>
		    <a class="item" href="http://hermes.kcreativa.com/script/solicitud.php?Hcliente=111&quien=C&Husuario=<?php echo $coiusuario; ?>" target="_blank">Pedir soporte tecnico</a>
                </div>
            </td>
            <td width=200px>
                &nbsp;
            </td>    
            <td>
                <a class="button" href="javascript:history.go(-1)"><img src="menu/images/back.png" border=0 align=middle> Atras</a>
            </td>
            <td>
                <a class="button" href="stock.php"><img src="menu/images/gohome.png" border=0 align=middle>Inicio</a>
            </td>	    
            <td>
                <a class="button" href="javascript:location.reload()"><img src="menu/images/reload.png" border=0 align=middle>Recargar</a>
            </td>	    
            <td>
                <a class="button" href="javascript:window.contenido.print()"><img src="menu/images/fileprint.png" border=0 align=middle>Imprimir</a>
            </td>
            <td>
                <a class="button" href="desconectar.php"><img src="menu/images/exit.png" border=0 align=middle>Salir</a>
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
