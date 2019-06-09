<?php
function conectar()
{
    $link = mysql_connect("elias","apolonia","virgen");

    $db = mysql_select_db("apolonia");
    
    return($db);
}

function desconectar()
{
    mysql_close();
}

function query($q)
{
    $query = mysql_query($q);
    
    return($query);
}

function fetch($link)
{
    $reg = mysql_fetch_object($link);
    
    return($reg);
}

function filas($link)
{
    $reg = mysql_num_rows($link);
    
    return($reg);
}
?>
