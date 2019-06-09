<?
include("Examplemysqlconfig.php");
include("mysqlphpgrid.class.php");
class Mytablegrid extends mysqlphpgrid {
	protected function select(){
		$res = mysql_query("SELECT id, Code, Name, Continent, SurfaceArea FROM $this->table WHERE Continent='Europe'" . $this->orderbystr, $this->conn) or die(mysql_error());
		return ($res);
	}
	function add(){
		mysql_query("INSERT INTO $this->table (Continent) VALUES('Europe')", $this->conn) or die(mysql_error());
		if (mysql_affected_rows($this->conn) == 1) return(true); else return(false);
	}
}
$grid = new mytablegrid($server, $user, $pw, $db, $table);
$grid->UpdateData();
?>
<html><head>
<link rel="stylesheet" type="text/css" href="style1.css"/>
<title>Example3</title>
</head><body>
<H3>Using MySQLPHPGrid on a subset of columns and records:</H3>

<? echo $grid->ShowTable(); ?>

<p>Only the records for Europe were selected and only five columns are displayed.<br>
</p>
</body></html>