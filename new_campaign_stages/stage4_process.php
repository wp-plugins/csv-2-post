<?php
if(empty($_POST['customfieldsmethod']))
{
	echo '<h3>You have not selected a method</h3>';
}
else
{
	$customfieldsmethod = $_POST['customfieldsmethod'];
	
	# IF MANUAL OR MIXED CUSTOM FIELDS METHOD SELECTED THEN PROCESS THE OTHER FORMS FIELDS ALSO
	if($customfieldsmethod == 'manual')
	{
		if(!empty($_POST['manual_customfield1a']) && empty($_POST['manual_customfield1b']))
		{
			echo '<div id="message" class="updated fade"><p>Sorry you did not enter an Assigned Value for the first row!</p></div>';
		}
		elseif(empty($_POST['manual_customfield1a']) && !empty($_POST['manual_customfield1b']))
		{
			echo '<div id="message" class="updated fade"><p>Sorry you did not enter an Identified for the first row!</p></div>';
		}
		elseif(!empty($_POST['manual_customfield1a']) && !empty($_POST['manual_customfield1b']))
		{
			$ident = $_POST['manual_customfield1a'];
			$value = $_POST['manual_customfield1b'];
			$sqlQuery = "INSERT INTO " .
			$wpdb->prefix . "csv2post_customfields(camid,identifier,value,type)
			VALUES('$camid','$ident','$value','0')";
			$wpdb->query($sqlQuery);
		}			

		if(!empty($_POST['manual_customfield2a']) && empty($_POST['manual_customfield2b']))
		{
			echo '<div id="message" class="updated fade"><p>Sorry you did not enter an Assigned Value for the second row!</p></div>';
		}
		elseif(empty($_POST['manual_customfield2a']) && !empty($_POST['manual_customfield2b']))
		{
			echo '<div id="message" class="updated fade"><p>Sorry you did not enter an Identified for the second row!</p></div>';
		}
		elseif(!empty($_POST['manual_customfield2a']) && !empty($_POST['manual_customfield2b']))
		{
			$ident = $_POST['manual_customfield2a'];
			$value = $_POST['manual_customfield2b'];
			$sqlQuery = "INSERT INTO " .
			$wpdb->prefix . "csv2post_customfields(camid,identifier,value,type)VALUES('$camid','$ident','$value','0')";
			$wpdb->query($sqlQuery);
		}

		if(!empty($_POST['manual_customfield3a']) && empty($_POST['manual_customfield3b']))
		{
			echo '<div id="message" class="updated fade"><p>Sorry you did not enter an Assigned Value for the third row!</p></div>';
		}
		elseif(empty($_POST['manual_customfield3a']) && !empty($_POST['manual_customfield3b']))
		{
			echo '<div id="message" class="updated fade"><p>Sorry you did not enter an Identified for the third row!</p></div>';
		}
		elseif(!empty($_POST['manual_customfield3a']) && !empty($_POST['manual_customfield3b']))
		{
			$ident = $_POST['manual_customfield3a'];
			$value = $_POST['manual_customfield3b'];
			$sqlQuery = "INSERT INTO " .
			$wpdb->prefix . "csv2post_customfields(camid,identifier,value,type)VALUES('$camid','$ident','$value','0')";
			$wpdb->query($sqlQuery);
		}		
		
		// build code to check submitted values
		$typ2_counter = 1;
    	$fields = get_option('csv2post_stage4fieldscolumns') + 1;
		while($typ2_counter < $fields)
		{
            $php_code =	 'if(isset($_POST["customfield' . $typ2_counter . 'a"]) && !empty($';
			$php_code .= '_POST["customfield'. $typ2_counter . 'b"]))
            {
                $ident = $_POST["customfield' . $typ2_counter . 'a"];
                $value = $_POST["customfield' . $typ2_counter . 'b"];
            }';
			eval($php_code);
			$value = $value - 1;// adjust counter value so first column is 0
			$sqlQuery = "INSERT INTO " . $wpdb->prefix . "csv2post_customfields(camid,identifier,value,type)VALUES('$camid','$ident','$value','1')";
			$wpdb->query($sqlQuery);
			$typ2_counter++;
		}
	}// end if manual or mixed
	
	# UPDATE CAMPAIGN STAGE COUNTER
	$sqlQuery = "UPDATE " .	$wpdb->prefix . "csv2post_campaigns SET stage='5',customfieldsmethod = '$customfieldsmethod' WHERE id = '$camid'";
	$wpdb->query($sqlQuery);

	$campaign = get_option( $_POST['camid_option'] );
	$campaign['settings']['stage'] = '5';
	$campaign['settings']['customfield'] = $customfieldsmethod;
	update_option( $_POST['camid_option'], $campaign );
	
	$stage4complete = true;

}// end if empty customfieldmethod

?>