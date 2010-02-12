<?php
# PROCESS SUBMISSION AND EITHER FORWARD TO NEXT STAGE OR DISPLAY ERRORS
if(empty($_POST['campaignname']) || !is_string($_POST['campaignname']))
{
	echo '<div id="message" class="updated fade"><p>Invalid campaign name please try again!</p></div>';
}
elseif(!empty($_POST['campaignname']) || is_string($_POST['campaignname']))
{
	if(empty($_POST['csvfilename']))
	{
		echo '<div id="message" class="updated fade"><p>Please select a CSV file</p></div>';
	}
	elseif(!empty($_POST['csvfilename']))
	{
		# ENSURE ALL REQUIRED OPTIONS SELECTED AND COMPLETE
		if(empty($_POST['processrate']))
		{
			echo '<div id="message" class="updated fade"><p>Sorry no process rate selected</p></div>';
		}
		else
		{
			# ALL REQUIRED DETAILS CAPTURED SO NOW PROCESS
			$camname = $_POST['campaignname'];
			$process = $_POST['processrate'];
			$csvfilename = $_POST['csvfilename'];
			
			// set daily posts then schedule processing
			if($process == 3)
			{
				if(empty($_POST['processratescheduled']))
				{
					$campaignarray['settings']['scheduledhour'] = 24;
				}
				else
				{
					$campaignarray['settings']['scheduledhour'] = $_POST['processratescheduled'];
				}
				
				// figure out the spread of posts over 24 hour period (86400 seconds)
				$interval = 86400 / $schedulednumber;
				$starttime = 0;// 
				
				$i = 0;
				
				$accumulation = 0;
				
				while($i < $schedulednumber)
				{	
					$i++;
					wp_schedule_event(time()+$accumulation, 'daily', 'cronschedulledprocessing');
					$accumulation = $accumulation + $interval;
				}
			}
			
			// get csv file directory
			$target_path = csv2post_getcsvfilesdir();

			$csvfiledirectory = $target_path . $csvfilename;
			
			# LINK LOCATION - FULL PROCESSING 						
			$fileexists = file_exists($csvfiledirectory);
			
			if($fileexists == false)
			{
				echo '<div id="message" class="updated fade"><p>CSV file not found</p></div>';
			}
			elseif(!isAllowedExtension_csv2post($csvfiledirectory))
			{
				echo '<div id="message" class="updated fade"><p>Sorry a slight problem! Only CSV files are allowed please try again</p></div>';
			}
			else
			{	
				// file exists - store name for displaying as "Last Used Filename"
				update_option('csv2post_lastfilename',$csvfilename);
							
				// create campaign data
				$camid_option = csv2post_createcampaign();
				// update campaign data
				$campaignarray = get_option( $camid_option );	

				$campaignarray['settings']['camid_option'] = $camid_option;
				$campaignarray['settings']['stage'] = '2';
				$campaignarray['settings']['name'] = $camname;
				$campaignarray['settings']['process'] = $process;
				$campaignarray['settings']['file'] = $csvfilename;
				$campaignarray['settings']['staggeredratio'] = get_option('csv2post_postsperhit_global');
					
				$sqlQuery = "INSERT INTO " . $wpdb->prefix . "csv2post_campaigns(camname,camid_option,stage,process)VALUES('$camname', '$camid_option','2','$process')";
				$stage1complete = csv2post_queryresult($wpdb->query($sqlQuery));
				$camid = $wpdb->insert_id;
				
				// update the wp options array for this campaign
				update_option( $camid_option, $campaignarray );
			}
		}// check all required posts populated
	}// end of ensure file selected
}// campaign name not empty and is string
?>