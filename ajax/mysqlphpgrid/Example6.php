<?
include("Examplemysqlconfig.php");
include("mysqlphpgrid.class.php");
class Mytablegrid extends mysqlphpgrid {
	protected function select(){
		$res = mysql_query("SELECT * FROM $this->table WHERE Continent='Antarctica'" . $this->orderbystr, $this->conn) or die(mysql_error());
		return ($res);
	}
	function add(){
		mysql_query("INSERT INTO $this->table (Continent) VALUES('Antarctica')", $this->conn) or die(mysql_error());
		if (mysql_affected_rows($this->conn) == 1) return(true); else return(false);
	}
}
$grid = new mytablegrid($server, $user, $pw, $db, $table);
$grid->show_id_field = false;
$grid->UpdateData();
?>
<html><head>
<link rel="stylesheet" type="text/css" href="style1.css"/>
<title>Example6</title>
</head><body>
<H3>The id field is hidden:</H3>

<? echo $grid->ShowTable(); ?>

</body></html>