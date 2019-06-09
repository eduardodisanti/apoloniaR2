<?
include("Examplemysqlconfig.php");
include("mysqlphpgrid.class.php");
$grid = new mysqlphpgrid($server, $user, $pw, $db, $table);
$grid->UpdateData();
?>
<html><head>
<link rel="stylesheet" type="text/css" href="style1.css"/>
<title>Example1</title>
<H3>Using MySQLPHPGrid on a full table with pagination:</H3>
</head><body>

<? echo $grid->ShowTable(); ?>

</body></html>