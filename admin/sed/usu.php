<?
include("../ajax/mysqlphpgrid/Examplemysqlconfig.php");
//using MySQLPHPGrid on a subset of columns
include("../ajax/mysqlphpgrid/mysqlphpgrid.class.php");
class Mytablegrid extends mysqlphpgrid {
	protected function select(){
		$res = mysql_query("SELECT * FROM $this->table " . $this->orderbystr, $this->conn) or die(mysql_error());
		return ($res);
	}
	function add(){
		mysql_query("INSERT INTO $this->table  VALUES('','','',0,'',0,0,'')", $this->conn) or die(mysql_error());
		if (mysql_affected_rows($this->conn) == 1) return(true); else return(false);
	}
}
$grid = new mytablegrid($server, $user, $pw, $db, $table);
$grid->UpdateData();
?>
<html><head>
<link rel="stylesheet" type="text/css" href="style1.css"/>
<title>Usuarios</title>
</head><body>

<? echo $grid->ShowTable(); ?>

</body></html>
