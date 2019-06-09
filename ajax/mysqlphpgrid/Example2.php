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
$grid->UpdateData();
?>
<html><head>
<link rel="stylesheet" type="text/css" href="style1.css"/>
<title>Example2</title>
</head><body>
<H3>Using MySQLPHPGrid on a subset of records:</H3>

<? echo $grid->ShowTable(); ?>

<p>Only the records for Antarctica were selected.<br>
If you add a record it will be set to Antarctica.<br>
Note the drop down list when editing a Continent field.<br>
The drop down list is generated from the Enum field in the MySQL database.</p>
</body></html>