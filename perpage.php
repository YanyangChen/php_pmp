<?php
	require_once("sessionmemo.php");

	function perpage($count, $per_page = '10',$href) {
		$output = '';
		$paging_id = "link_perpage_box";
		if(!isset($_POST["page"])) $_POST["page"] = 1;
		if(isset($_SESSION["sscontrol"])){
		if($_SESSION["sscontrol"]->check_sent() == "sent") {$_POST["page"] = $_SESSION["sscontrol"]->page;}}
		if($per_page != 0)
		$pages  = ceil($count/$per_page);
		$output = $output . '<input type="text" name="page" class="perpage-link" placeholder="to page"/>' . '<input type="submit" class="perpage-link" value="Go">';
		if($pages>1) {
			
			if(($_POST["page"]-3)>0) {
				if($_POST["page"] == 1)
					$output = $output . '<span id=1 class="current-page">1</span>';
				else				
					$output = $output . '<input type="submit" name="page" class="perpage-link" value="1" />';
			}
			if(($_POST["page"]-3)>1) {
					$output = $output . '...';
			}
			
			for($i=($_POST["page"]-2); $i<=($_POST["page"]+2); $i++)	{
				if($i<1) continue;
				if($i>$pages) break;
				if($_POST["page"] == $i)
					$output = $output . '<span id='.$i.' class="current-page" >'.$i.'</span>';
				else				
					$output = $output . '<input type="submit" name="page" class="perpage-link" value="' . $i . '" />';
			}
			
			if(($pages-($_POST["page"]+2))>1) {
				$output = $output . '...';
			}
			if(($pages-($_POST["page"]+2))>0) {
				if($_POST["page"] == $pages)
					$output = $output . '<span id=' . ($pages) .' class="current-page">' . ($pages) .'</span>';
				else				
					$output = $output . '<input type="submit" name="page" class="perpage-link" value="' . $pages . '" />';
			}
			
		}
		return $output;
	}
	
	function showperpage($sql, $per_page = 10, $href) {
		$result  = mysql_query($sql);
		$count   = mysql_num_rows($result);
		$perpage = perpage($count, $per_page,$href);
		return $perpage;
	}
?>