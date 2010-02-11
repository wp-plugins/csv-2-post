<?php
if(!isset($_POST['poststatus']))
{
	echo '<div id="message" class="updated fade"><p>You did not select a post status</p></div>';
}
elseif(isset($_POST['poststatus']))
{
	$status = $_POST['poststatus'];

	if(isset($_POST['randomdate']) && $_POST['randomdate'] == 1)
	{
		$randomdate = $_POST['randomdate'];
	}
	else
	{
		$randomdate = 0;
	}
	
	global $wpdb;
	
	# UPDATE CAMPAIGN STAGE COUNTER
	$sqlQuery = "UPDATE " .
	$wpdb->prefix . "csv2post_campaigns SET stage = '4', poststatus = '$status',randomdate = '$randomdate' WHERE id = '$camid'";
	$wpdb->query($sqlQuery);
	$stage3complete = true;
}
?>