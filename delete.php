<?php
require_once("dbcontroller.php");

session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: user/loginb.php");
    exit;
}

$db_handle = new DBController();
if(!empty($_GET["id"])) {
	$result = mysql_query("DELETE FROM cyy.PMP WHERE id=".$_GET["id"]);
	if(!empty($result)){
		header("Location:index.php");
	}
}
?>