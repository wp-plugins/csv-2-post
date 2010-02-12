<?php
if(!isset($_POST['poststatus']))
{
	echo '<div id="message" class="updated fade"><p>You did not select a post status</p></div>';
}
elseif(isset($_POST['poststatus']))
{
	global $wpdb;

	$status = $_POST['poststatus'];

	if(isset($_POST['randomdate']) && $_POST['randomdate'] == 1)
	{
		$randomdate = $_POST['randomdate'];
	}
	else
	{
		$randomdate = 0;
	}
	
	# UPDATE CAMPAIGN STAGE COUNTER
	$sqlQuery = "UPDATE " .	$wpdb->prefix . "csv2post_campaigns SET stage='4', randomdate = '$randomdate' WHERE id = '$camid'";
	$wpdb->query($sqlQuery);
	$stage3complete = true;
	
	$campaign = get_option( $_POST['camid_option'] );
	$campaign['settings']['stage'] = '4';
	$campaign['settings']['poststatus'] = $status;
	$campaign['settings']['randomdate'] = $randomdate;
	update_option( $_POST['camid_option'], $campaign );
}
?>