<html>
  <head>
    <title>
      Poner Suplentes 
    </title>
  <body bgcolor="#2693ae">
     <form action="grabosuplentes.php" method=post>
       <center>
       <h2>Poner Suplentes</h2>
       <hr>
       <table border=1 width=40%>
       
       <tr bgcolor="#abbbbb">
          <td><b>Fecha desde:</b></td><td>DD <input type="text" value="" name="dd1" maxlenght=2 size=2></td>
                     <td>MM <input type="text" value="" name="mm1" maxlenght=2 size=2></td>
                     <td>AAAA <input type="text" value="" name="aa1" maxlenght=4 size=4></td>
       </tr>
       <tr bgcolor="#abbbbb">
       <td><b>Fecha hasta:&nbsp</b></td> <td>DD <input type="text" value="" name="dd2" maxlenght=2 size=2></td>
                     <td>MM <input type="text" value="" name="mm2" maxlenght=2 size=2></td>
                     <td>AAAA <input type="text" value="" name="aa2" maxlenght=4 size=4></td>
      </tr>
      <tr bgcolor="#aaaaaa">
         <td><b>Odontologo </b></td><td colspan=3>
            <select name="medfalta">
                <?php
                    $link=mysql_connect("elias","apolonia","virgen");
                    $db=mysql_select_db("apolonia");
                    $qry=mysql_query("select * from Medicos where Activo='S' order by Nombre asc");
                    while($reg=mysql_fetch_object($qry))
                       {
                            $nombre=$reg->Nombre;
                            $numero=$reg->Numero;
                            echo "<option value=$numero>$nombre</option>";
                       }

                 ?>
            </select>
         </td>
      </tr>
      </tr>
      <tr bgcolor="#aaaaaa">
         <td><b>Suplente    </b></td><td colspan=3>
              <select name="medsuple">
                  <?php
                    $qry=mysql_query("select * from Medicos where Activo='S' order by Nombre asc");
                    while($reg=mysql_fetch_object($qry))
                       {
                            $nombre=$reg->Nombre;
                            $numero=$reg->Numero;
                            echo "<option value=$numero>$nombre</option>";
                       }

                 ?>
              </select>
         </td>
      </tr>

      <tr bgcolor="#accaaa">
         <td><b>Turno desde</b></td><td colspan=3><input type="text" value="" name="turno1" size=2></td>
      </tr>
      </tr>
      <tr bgcolor="#accaaa">
         <td><b>Turno hasta</b></td><td colspan=3><input type="text" value="" name="turno2" size=2></td>
      </tr>
      <tr bgcolor="#accaaa">
         <td><b>Consultorio</b></td><td colspan=3><input type="text" value="" name="consultorio" size=5></td>
      </tr>
</table>
      <hr>
         <input type="SUBMIT" name="Aceptar" value="Aceptar suplencia">
         &nbsp;&nbsp;&nbsp;<input type="SUBMIT" name="Cancelar" Value="Cancelar" onclick="window.close()">
     </form>
  </body>
</html>
