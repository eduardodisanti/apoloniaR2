<?
include("Examplemysqlconfig.php");
include("mysqlphpgrid.class.php");
class Mytablegrid extends mysqlphpgrid {
	protected function select(){
		$res = mysql_query("SELECT * FROM $this->table" . $this->orderbystr, $this->conn) or die(mysql_error());
		return ($res);
	}
	function add(){
		mysql_query("INSERT INTO $this->table (Continent) VALUES('Antarctica')", $this->conn) or die(mysql_error());
		if (mysql_affected_rows($this->conn) == 1) return(true); else return(false);
	}
}
$grid = new mytablegrid($server, $user, $pw, $db, $table);
$grid->add_allowed 		= false;
$grid->delete_allowed 	= false;
$grid->update_allowed 	= false;
$grid->UpdateData();
?>
<html><head>
<link rel="stylesheet" type="text/css" href="style1.css"/>
<title>Example4</title>
</head><body>
<H3>No editing allowed:</H3>

<?
echo $grid->ShowTable(); 
?>

</body></html>