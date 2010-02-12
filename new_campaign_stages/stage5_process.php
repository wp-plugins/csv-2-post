<?php

global $wpdb;

$pfm = $_POST['filtermethod'];

if(empty($pfm))
{
	echo '<div id="message" class="updated fade"><p>You did not select a filter method</p></div>';
}
else
{
	if($pfm == 'manual' || $pfm == 'mixed')// mixed and manual requires more data from form
	{
		if(!empty($_POST['cat1a']))
		{
			# SAVE TO CUSTOM FIELD TABLE
			$value = $_POST['cat1a'];
			$cat = $_POST['cat1b'];
			$sqlQuery = "INSERT INTO " .
			$wpdb->prefix . "csv2post_categories(camid,catid,uniquevalue)
			VALUES('$camid','$cat','$value')";
			$wpdb->query($sqlQuery);
		}
		
		if(!empty($_POST['cat2a']))
		{
			# SAVE TO CUSTOM FIELD TABLE
			$value = $_POST['cat2a'];
			$cat = $_POST['cat2b'];
			$sqlQuery = "INSERT INTO " .
			$wpdb->prefix . "csv2post_categories(camid,catid,uniquevalue)
			VALUES('$camid','$cat','$value')";
			$wpdb->query($sqlQuery);
		}

		if(!empty($_POST['cat3a']))
		{
			# SAVE TO CUSTOM FIELD TABLE
			$value = $_POST['cat3a'];
			$cat = $_POST['cat3b'];
			$sqlQuery = "INSERT INTO " .
			$wpdb->prefix . "csv2post_categories(camid,catid,uniquevalue)
			VALUES('$camid','$cat','$value')";
			$wpdb->query($sqlQuery);
		}

		if(!empty($_POST['cat4a']))
		{
			# SAVE TO CUSTOM FIELD TABLE
			$value = $_POST['cat4a'];
			$cat = $_POST['cat4b'];
			$sqlQuery = "INSERT INTO " .
			$wpdb->prefix . "csv2post_categories(camid,catid,uniquevalue)
			VALUES('$camid','$cat','$value')";
			$wpdb->query($sqlQuery);
		}
		if(!empty($_POST['cat5a']))
		{
			# SAVE TO CUSTOM FIELD TABLE
			$value = $_POST['cat5a'];
			$cat = $_POST['cat5b'];
			$sqlQuery = "INSERT INTO " .
			$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
			VALUES('$camid','$cat','$value')";
			$wpdb->query($sqlQuery);
		}
		if(!empty($_POST['cat6a']))
		{
			# SAVE TO CUSTOM FIELD TABLE
			$value = $_POST['cat6a'];
			$cat = $_POST['cat6b'];
			$sqlQuery = "INSERT INTO " .
			$wpdb->prefix . "csv2post_categories(camid,catid,uniquevalue)
			VALUES('$camid','$cat','$value')";
			$wpdb->query($sqlQuery);
		}
		if(!empty($_POST['cat7a']))
		{
			# SAVE TO CUSTOM FIELD TABLE
			$value = $_POST['cat7a'];
			$cat = $_POST['cat7b'];
			$sqlQuery = "INSERT INTO " .
			$wpdb->prefix . "csv2post_categories(camid,catid,uniquevalue)
			VALUES('$camid','$cat','$value')";
			$wpdb->query($sqlQuery);
		}
		if(!empty($_POST['cat8a']))
		{
			# SAVE TO CUSTOM FIELD TABLE
			$value = $_POST['cat8a'];
			$cat = $_POST['cat8b'];
			$sqlQuery = "INSERT INTO " .
			$wpdb->prefix . "csv2post_categories(camid,catid,uniquevalue)
			VALUES('$camid','$cat','$value')";
			$wpdb->query($sqlQuery);
		}
		if(!empty($_POST['cat9a']))
		{
			# SAVE TO CUSTOM FIELD TABLE
			$value = $_POST['cat9a'];
			$cat = $_POST['cat9b'];
			$sqlQuery = "INSERT INTO " .
			$wpdb->prefix . "csv2post_categories(camid,catid,uniquevalue)
			VALUES('$camid','$cat','$value')";
			$wpdb->query($sqlQuery);
		}
		if(!empty($_POST['cat10a']))
		{
			# SAVE TO CUSTOM FIELD TABLE
			$value = $_POST['cat11a'];
			$cat = $_POST['cat11b'];
			$sqlQuery = "INSERT INTO " .
			$wpdb->prefix . "csv2post_categories(camid,catid,uniquevalue)
			VALUES('$camid','$cat','$value')";
			$wpdb->query($sqlQuery);
		}
		if(!empty($_POST['cat12a']))
		{
			# SAVE TO CUSTOM FIELD TABLE
			$value = $_POST['cat12a'];
			$cat = $_POST['cat12b'];
			$sqlQuery = "INSERT INTO " .
			$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
			VALUES('$camid','$cat','$value')";
			$wpdb->query($sqlQuery);
		}
		if(!empty($_POST['cat13a']))
		{
			# SAVE TO CUSTOM FIELD TABLE
			$value = $_POST['cat13a'];
			$cat = $_POST['cat13b'];
			$sqlQuery = "INSERT INTO " .
			$wpdb->prefix . "csv2post_categories(camid,catid,uniquevalue)
			VALUES('$camid','$cat','$value')";
			$wpdb->query($sqlQuery);
		}
		if(!empty($_POST['cat14a']))
		{
			# SAVE TO CUSTOM FIELD TABLE
			$value = $_POST['cat14a'];
			$cat = $_POST['cat14b'];
			$sqlQuery = "INSERT INTO " .
			$wpdb->prefix . "csv2post_categories(camid,catid,uniquevalue)
			VALUES('$camid','$cat','$value')";
			$wpdb->query($sqlQuery);
		}
		if(!empty($_POST['cat15a']))
		{
			# SAVE TO CUSTOM FIELD TABLE
			$value = $_POST['cat15a'];
			$cat = $_POST['cat15b'];
			$sqlQuery = "INSERT INTO " .
			$wpdb->prefix . "csv2post_categories(camid,catid,uniquevalue)
			VALUES('$camid','$cat','$value')";
			$wpdb->query($sqlQuery);
		}
	}
	
	$filtercolumn =	$_POST['optedfiltercolumn'];
	$filtercolumn2 = $_POST['optedfiltercolumn2'];
	$filtercolumn3 = $_POST['optedfiltercolumn3'];
	@$defaultpostcategory = $_POST['defaultpostcategory'];
	$defaultphase =	get_option('csv2post_defaultphase');

	$sqlQuery = "UPDATE " .	$wpdb->prefix . "csv2post_campaigns SET stage='100' WHERE id = '$camid'";
	$wpdb->query($sqlQuery);

	$campaign = get_option( $_POST['camid_option'] );
	$campaign['settings']['stage'] = '5';
	$campaign['settings']['updatesetting'] = $defaultphase;
	$campaign['settings']['catparent'] = $filtercolumn;
	$campaign['settings']['catchild1'] = $filtercolumn2;
	$campaign['settings']['catchild2'] = $filtercolumn3;
	$campaign['settings']['catdefault'] = $defaultpostcategory;
	$campaign['settings']['categorymethod'] = $pfm;	
	update_option( $_POST['camid_option'], $campaign );
	
	$stage5complete = true;

}// end if filter method selected
?>