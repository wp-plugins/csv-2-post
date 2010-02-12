<?php
# STAGE 2 SUBMISSION MADE - PROCESS POST VARIABLES, THEY SHOULD BE POPULATED AND VALIDATED BEFORE THIS SUBMISSION
$camid = $_POST['camid'];
$csvfiledirectory = $_POST['csvfiledirectory'];
$csvfile_columntotal = $_POST['csvfile_columntotal'];

function csv2post_countcsvrows($csvfiledirectory,$delimiter)
{
	// count total number of rows
	$rows_total = 1;
	$handle2 = fopen($csvfiledirectory , "r");
	while (($data = fgetcsv($handle2, 5000, $delimiter)) !== FALSE)
	{
		$rows_total++;// used to limit row parsing to just 1
	}//end while rows
	fclose($handle2);
	return $rows_total;// will return data rows total not
}


// put every single column into relationship table and assume a match - used with the WYSIWYG Editor
$handle = fopen($csvfiledirectory , "r");

$csvprofile = csv2post_getcsvprofile( $_POST['csvfilename'] );

$i = 0;
$stop_rows = 0;
while (($data = fgetcsv($handle, 5000, $csvprofile['format']['delimiter'])) !== FALSE && $stop_rows != 1)// get first csv row
{	 
	$stop_rows++;// used to limit row parsing to just 1
		   
	while(isset($data[$i]))
	{
		$data[$i] = rtrim($data[$i]);

		# THIS POST IS A COLUMN TO POST RELATIONSHIP
		$sqlQuery = "INSERT INTO " .
		$wpdb->prefix . "csv2post_relationships(camid, csvcolumnid, postpart) VALUES ('$camid', '$i','$data[$i]')";
		$wpdb->query($sqlQuery);
		
		$i++; // $i will equal number of columns - use to process submission
	}
}//end while rows
fclose($handle);

$rows_total = csv2post_countcsvrows($csvfiledirectory,$csvprofile['format']['delimiter']);		

// function used for special column function submission and to determine the first set state
function csv2post_decidestate($v){  if( $v == 0 ){ return 'OFF'; }elseif( $v != 0 ){ return 'ON'; } }

// first get the current array so that it is edited, not overwritten
$optionname = 'csvprofile_' . $_POST['csvfilename'];
$specialfunctions = get_option($optionname);

// the state is a boolean switch which will be used to switch the special function on or off per campaign on stage 2
$specialfunctions['states']['excerpt_state'] = csv2post_decidestate(@$_POST['excerpt_column']);
$specialfunctions['states']['tags_state'] = csv2post_decidestate(@$_POST['tags_column']);
$specialfunctions['states']['uniqueid_state'] = csv2post_decidestate(@$_POST['uniqueid_column']);
$specialfunctions['states']['urlcloaking_state'] = csv2post_decidestate(@$_POST['urlcloaking_column']);
$specialfunctions['states']['permalink_state'] = csv2post_decidestate(@$_POST['permalink_column']);
$specialfunctions['states']['dates_state'] = csv2post_decidestate(@$_POST['dates_column']);
$specialfunctions['format']['rows'] = $rows_total;
update_option( $optionname, $specialfunctions );
			
$campaign = get_option( $_POST['camid_option'] );
$campaign['settings']['stage'] = '3';
update_option( $_POST['camid_option'], $campaign );

$sqlQuery = "UPDATE " .	$wpdb->prefix . "csv2post_campaigns SET stage='3' WHERE id = '$camid'";
$wpdb->query($sqlQuery);
	
$stage2complete = true;

?>