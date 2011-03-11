<br />
<?php	
// if speed profile not set, offer profiles list only else also display import actions
if( !isset( $pro[$pro['current']]['speed'] ) )
{    
	echo 'Your project does not have an Events Speed set. This is meant to be set on the
	Create Project form and must mean that it failed to save or the speed setting was deleted.
	Please report this problem and seek support.';
}
else
{
    // get speed profile type (not name) to determine output
    $speedtype = $spe[$pro[$pro['current']]['speed']]['type'];
    
	// calculate progress
	$progress = $pro[$pro['current']]['rowsinsertfail'] + $pro[$pro['current']]['rowsinsertsuccess'];
	
	// get project tables row count
	$records = c2pf_counttablerecords( $pro['current'] );
	
	// if imported records equal csv rows - do not show import button - show undo button to delete records instead
	if( isset( $csv['format']['rows'] ) && $records >= $csv['format']['rows'] )
	{		
		echo '<h4>Data Import Complete</h4><p>Number of records in the project table matches number of rows in your csv file.
		No further importing is required.</p>';
	}
	elseif( isset( $csv['format']['rows'] ) && $progress >= $csv['format']['rows'] )
	{
		echo '<h4>Data Import Complete</h4><p>Your project statistics show that the plugin may have failed to import some rows from your
		csv file to the project table. However it has processed every csv file row and will not continue any importing attempts. If
		you believe you can improve the import success rate or are simply testing your project you may use the Re-Create Table button provided to
		delete all project data and reset progress counters. This button will delete your project table and then re-create it.'.$undobutton.'</p>';
	}
	else
	{
		// create import button - change values to trigger different processing when submitted
		$buttontext = 'Import Data';
		$buttonname = 'c2pf_datatransfer_submit';
		
		$importbutton = '
			<form method="post" name="c2pf_importstage_form" action="">  
				<input name="c2pf_filename" type="hidden" value="'.$pro['current'].'" />
				Encoding To Apply:
				<select name="c2pf_encoding_importencoding" size="s">
					<option value="None">None</option>
					<option value="None">UTF-8 Standard Function (encoding requires you to hire WebTechGlobal for support)</option>
					<option value="None">UTF-8 Full (encoding requires you to hire WebTechGlobal for support)</option>
				</select>
				<br /><br />
				<input class="button-primary" type="submit" name="'.$buttonname.'" value="'.$buttontext.'" />
			</form>
		<br />';
	
		echo '<h4>Manual Events Import</h4><p>You have selected Manual Events. You are required to initiate many seperate import jobs. You can wait 
		as long as you want to between each event and the plugin will not initiate an event automatically. You may
		also change the Speed Profile event after some events have been actioned. Please click the Import button to 
		run an event.</p>'.$importbutton;
	}
}
?>
<br />
