<?php
	require_once("perpage.php");	
	require_once("dbcontroller.php");
	require_once("sessionmemo.php");
	$db_handle = new DBController();
	
	/* if (!isset($topic) and !isset($code) and !isset($text) and !isset($mark1) and !isset($mark2))
	{ */
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: user/loginb.php");
    exit;
}
$renew = $_SESSION['renew'];
/* echo $renew; */
$sscontrol = new SSController();
if(!empty($_SESSION['sscontrol']))
{
	$sscontrol = $_SESSION['sscontrol'];
}
echo $topic;
/* $topic = $_SESSION['topic']; */
if (!isset($renew)){
	$topic = "";
	$code = "";
	$text = "";
	$mark1 = "";
	$mark2 = "";
	$queryCondition = "";
	//}
	}
	if(!empty($_POST["search"])) {
		if($_POST["gosearch"]){
		$sscontrol->clear_sent();
		}
		if($sscontrol->check_sent() == "sent") //if search button has not been clicked
		{
			$_SESSION['search'] = $sscontrol->search; //search criteria remains unchanged
		}
		else //otherwise it means this page was not sent back by edit page and session should be set for search being sent back
		{
			$_SESSION['search'] = $_POST["search"]; //
		}
		//$_SESSION['search'] = $_POST["search"];
		foreach($_POST["search"] as $k=>$v){
			if(!empty($v)) {

				$queryCases = array("topic","code","text","mark1","mark2");
				if(in_array($k,$queryCases)) {
					if(!empty($queryCondition)) {
						$queryCondition .= " AND ";
					} else {
						$queryCondition .= " WHERE ";
					}
				}
				switch($k) {
					case "topic":
						$topic = $v;
						$queryCondition .= "topic LIKE '%" . $v . "%'";
						break;
					case "code":
						$code = $v;
						$queryCondition .= "code LIKE '%" . $v . "%'";
						break;
					case "text":
						$text = $v;
						$queryCondition .= "text LIKE '%" . $v . "%'";
						break;
					case "mark1":
						$mark1 = $v;
						$queryCondition .= "mark1 LIKE '%" . $v . "%'";
						break;
					case "mark2":
						$mark2 = $v;
						$queryCondition .= "mark2 LIKE '%" . $v . "%'";
						break;
					echo $v;
				}
			}
		}
		//if ($sscontrol->queryCondition != $queryCondition)
		//{
		//	$sscontrol->clear_sent();
		//}
		//$_SESSION["search"] = $_POST["search"];
	}
	/* $orderby = " ORDER BY topic, code asc";  */
	$orderby = ""; 
	$sql = "SELECT * FROM cyy.PMP " . $queryCondition;
	//if (isset($renew) and empty($_POST["search"])){
	//	$sql = "SELECT * FROM cyy.PMP " . " WHERE " . "topic LIKE '%" . $topic . "%'";
	//}
	$href = 'index.php';					
	/* echo $queryCondition;	 */
	$perPage = 10; 
	$page = 1;
	if(isset($_POST['page'])){
		$page = $_POST['page'];
	}
	if($sscontrol->check_sent() == "sent")
	{
		$page = $sscontrol->page;
		if(isset($_POST['page'])){
		$page = $_POST['page'];
		}
	}
	
	$start = ($page-1)*$perPage;
	if($start < 0) $start = 0;
		
	$query =  $sql . $orderby .  " limit " . $start . "," . $perPage; 
	if($sscontrol->check_sent() == "sent")
	{
		$sscontrol->page = $_SESSION['page'];
		if(isset($_POST['page'])){
		$sscontrol->page = $_POST['page'];
		}
		$result = $db_handle->runQuery($sscontrol->gen_query($sscontrol->search,"cyy.PMP"));
		echo "sscontrol->check_sent() is sent";
		echo "sscontrol->search is "; echo $sscontrol->search["topic"];
	}
	else{
		$result = $db_handle->runQuery($query);
	}
	if(!empty($result)) {
		if($sscontrol->check_sent() == "sent")
	{
		echo "sscontrol->page is";
		echo $sscontrol->page;
		$result["perpage"] = showperpage($sscontrol->sql, $perPage, $href);
		//$sscontrol->clear_sent();
	}
	else{
		$result["perpage"] = showperpage($sql, $perPage, $href);
		/* $sscontrol->clear_sent(); */
		}
	}
	
	$_SESSION['page'] = $page;
	
	$_SESSION['queryCases'] = $queryCases;
?>
<html>
	<head>
	<title>PMP prep</title>
	<link href="style.css" type="text/css" rel="stylesheet" />
	<style>
		my { 
			background-color: yellow;
			color: black;
		}
		
		mg { 
			background-color: green;
			color: black;
		}
		
		mr { 
			background-color: red;
			color: black;
		}
		
		x{
			 text-decoration: line-through;
		}
		
		u{
			 text-decoration: underl;
		}
		
		p span 
		{
			display: block;
		}
</style>
	</head>
	<body>
		<h2>PMP Q&A</h2>
		<div style="text-align:right;margin:20px 0px 10px;">
		<a id="btnAddAction" href="user/loginb.php">Login</a>
		<a id="btnAddAction" href="user/logoutb.php">Logout</a>
		<a id="btnAddAction" href="add.php">Add New</a>
		</div>
    <div id="toys-grid">      
			<form name="frmSearch" method="post" action="index.php">
			<div class="search-box">
			<p><select id="Place" name="search[topic]" class="demoInputBox">
				<option value=<?php echo $topic; ?>></option>
				<?php
					$topicResult = $db_handle->runQuery("SELECT DISTINCT topic FROM cyy.PMP ORDER BY topic ASC");
					if (! empty($topicResult)) {
						 foreach ($topicResult as $key => $value) {
							 echo '<option value="' . $topicResult[$key]['topic'] . '">' . $topicResult[$key]['topic'] . '</option>';
						 }
					 }
				?>
				
			</select>
    <!--<button id="Filter">Search</button>-->
			<!--<p><input type="text" placeholder="Topic" name="search[topic]" class="demoInputBox" value="<?php echo $topic; ?>"	/>-->
			
			<input type="text" placeholder="Code" name="search[code]" class="demoInputBox" value="<?php echo $code; ?>"	/>
			<input type="text" placeholder="text" name="search[text]" class="demoInputBox" value="<?php echo $text; ?>"	/>
			<input type="text" placeholder="mark1" name="search[mark1]" class="demoInputBox" value="<?php echo $mark1; ?>"	/>
			<input type="text" placeholder="mark2" name="search[mark2]" class="demoInputBox" value="<?php echo $mark2; ?>"/>
			<input type="submit" name="gosearch" class="btnSearch" value="Search"/><input type="reset" class="btnSearch" value="Reset" onclick="window.location='index.php'"/></p>
			</div>
			
			<table cellpadding="10" cellspacing="1">
        <thead>
					<tr>
          <th><strong>Topic</strong></th>
          <th><strong>Code</strong></th>          
          <th><strong>Text</strong></th>
					<th><strong>Mark1</strong></th>
					<th><strong>Mark2</strong></th>
					<th><strong>Action</strong></th>
					
					</tr>
				</thead>
				<tbody>
					<?php
						foreach($result as $k=>$v) {
						if(is_numeric($k)) {
					?>
          <tr>
					<td><?php echo $result[$k]["topic"]; ?></td>
					<td><?php echo $result[$k]["code"]; ?></td>
					<td><?php echo $result[$k]["text"]; ?></td>
					<td><?php echo $result[$k]["mark1"]; ?></td>
					<td><?php echo $result[$k]["mark2"]; ?></td> 
					<td>
					<a class="btnEditAction" href="edit.php?id=<?php echo $result[$k]["id"]; ?>">Edit</a> <a class="btnDeleteAction" href="delete.php?action=delete&id=<?php echo $result[$k]["id"]; ?>">Delete</a>
					</td>
					</tr>
					<?php
						}
					}
					if(isset($result["perpage"])) {
					?>
					<tr>
					
					<td colspan="6" align=right> <?php echo $result["perpage"]; ?></td>
					</tr>
					<?php } ?>
					
				<tbody>
			</table>
			
			</form>	
		</div>
		<script>
					function myFunction() {
						var x = document.getElementById("pagebox").value;
						document.getElementById("pagego").innerHTML = x;
					}
					</script>
	</body>
</html>
