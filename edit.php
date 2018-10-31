<?php
require_once("dbcontroller.php");
require_once("sessionmemo.php");
$db_handle = new DBController();
$memo = new SSController();



session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: user/loginb.php");
    exit;
}
$memo->set_page($_SESSION["page"]);
/* $memo->page = $_SESSION["page"]; */
$memo->set_queryCases($_SESSION["queryCases"]);
/* $memo->queryCases = $_SESSION["queryCases"]; */
$memo->search = $_SESSION["search"];
$renew = 'not';
$_SESSION['renew'] = $renew;
if(!empty($_POST["submit"])) {
	$_POST["text"] = str_replace("'","\'",$_POST["text"]);
	$_POST["topic"] = str_replace("'","\'",$_POST["topic"]);
	$_POST["code"] = str_replace("'","\'",$_POST["code"]);
	$_POST["mark1"] = str_replace("'","\'",$_POST["mark1"]);
	$_POST["mark2"] = str_replace("'","\'",$_POST["mark2"]);
	$result = mysql_query("UPDATE cyy.PMP set topic = '".$_POST["topic"]."', code = '".$_POST["code"]."', text = '".$_POST["text"]."', mark1 = '".$_POST["mark1"]."', mark2 = '".$_POST["mark2"]."' WHERE  id=".$_GET["id"]);
	if(!$result){
		$message = "Problem in Editing! Please Retry!";
	} else {
		header("Location:index.php");
	}
	$_SESSION['topic'] = $_POST["topic"];
}
$result = $db_handle->runQuery("SELECT * FROM cyy.PMP WHERE id='" . $_GET["id"] . "'");
$memo->set_sent();
$_SESSION["sscontrol"] = $memo;
?>
<link href="style.css" type="text/css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script>
function validate() {
	var valid = true;	
	$(".EditInputBox").css('background-color','');
	$(".info").html('');
	
	/* if(!$("#topic").val()) {
		$("#topic-info").html("(required)");
		$("#topic").css('background-color','#FFFFDF');
		valid = false;
	}
	if(!$("#code").val()) {
		$("#code-info").html("(required)");
		$("#code").css('background-color','#FFFFDF');
		valid = false;
	}
	if(!$("#text").val()) {
		$("#text-info").html("(required)");
		$("#text").css('background-color','#FFFFDF');
		valid = false;
	}
	if(!$("#mark1").val()) {
		$("#mark1-info").html("(required)");
		$("#mark1").css('background-color','#FFFFDF');
		valid = false;
	}	
	if(!$("#mark2").val()) {
		$("#mark2-info").html("(required)");
		$("#mark2").css('background-color','#FFFFDF');
		valid = false;
	}	 */
	return valid;
}
</script>
<form name="frmToy" method="post" action="" id="frmToy" onClick="return validate();">
<div id="mail-status"></div>
<div>
<label style="padding-top:20px;">topic</label>
<span id="topic-info" class="info"></span><br/>
<input type="text" name="topic" id="topic" class="EditInputBox" value="<?php echo $result[0]["topic"]; ?>">
</div>
<div>
<label>Code</label>
<span id="code-info" class="info"></span><br/>
<input type="text" name="code" id="code" class="EditInputBox" value="<?php echo $result[0]["code"]; ?>">
</div>
<div>
<label>text</label> 
<span id="text-info" class="info"></span><br/>
<input type="text" name="text" id="text" class="EditInputBox" value="<?php echo $result[0]["text"]; ?>">
</div>
<div>
<label>mark1</label> 
<span id="mark1-info" class="info"></span><br/>
<input type="text" name="mark1" id="mark1" class="EditInputBox" value="<?php echo $result[0]["mark1"]; ?>">
</div>
<div>
<label>mark2</label> 
<span id="mark2-info" class="info"></span><br/>
<input type="text" name="mark2" id="mark2" class="EditInputBox" value="<?php echo $result[0]["mark2"]; ?>">
</div>
<div>
<input type="submit" name="submit" id="btnAddAction" value="Save" />
</div>
</div>