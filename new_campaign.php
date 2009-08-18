<?php

# DEBUG DURING DEVELOPMENT
//define('WP_DEBUG',true);

global $wpdb;

$tutorial_url = '<p>Tutorials, instructions and videos can be found on my website. <a href="http://www.webtechglobal.co.uk/wordpress-services/wordpress-csv-2-post-plugin/csv-2-post-tutorial" title="View CSV 2 POST Help" target="_blank">View CSV 2 POST help here.</a></p>';

# STAGE 1: SUBMISSION OR FIRST TIME VISIT FOR CAPTURING INITIAL CAMPAIGN SETTINGS
if(!isset($_POST['stage']) || $_POST['stage'] == 1)
{
	if(!empty($_POST['campaignsubmit']))// is stage 1 form submission made?
	{
		# PROCESS SUBMISSION AND EITHER FORWARD TO NEXT STAGE OR DISPLAY ERRORS
		if(empty($_POST['campaignname']) || !is_string($_POST['campaignname']))
		{
			echo '<h2>Invalid campaign name please try again!</h2>';
		}
		elseif(!empty($_POST['campaignname']) || is_string($_POST['campaignname']))
		{
			# ENSURE ALL REQUIRED OPTIONS SELECTED AND COMPLETE
			if(empty($_POST['processrate']))
			{
				echo '<h2>Sorry no process rate selected</h2>';
			}
			elseif(!empty($_POST['processrate']) && $_POST['processrate'] == 2 && empty($_POST['rowratio']))
			{
				echo '<h2>Sorry you did not enter Row/Visitor ratio number</h2>';
			}
			elseif(!empty($_POST['processrate']) && empty($_POST['filelocationtype']))
			{
				echo '<h2>Please select a file location type</h2>';	
			}
			elseif(!empty($_POST['processrate']) && !empty($_POST['filelocationtype']) && $_POST['filelocationtype'] == 1 && empty($_POST['filelocationlocal']))
			{
				echo '<h2>You selected Link for your CSV file location type but did not provide the URL to your file</h2>';
			}	
			elseif(!empty($_POST['processrate']) && !empty($_POST['filelocationtype']) && $_POST['filelocationtype'] == 2 && empty($_FILES['csvupload']))
			{
				echo '<h2>You selected Upload for your CSV file location type but did not browse and select your CSV file!</h2>';
			}
			else
			{
				# ALL REQUIRED DETAILS CAPTURED SO NOW PROCESS
				$camname = $_POST['campaignname'];
				$process = $_POST['processrate'];
				$rowratio = $_POST['rowratio'];
				$csvfilename = $_POST['filelocationlocal'];
				$filelocationtype = $_POST['filelocationtype'];
				
				// get csv file directory
				$uploadpath = get_option( 'upload_path' );
				$target_path = $uploadpath.'/csv2postfiles/';

				# CALL UPLOAD PROCESS FUNCTION PASSING REQUIRED VALUES ONLY
				if($filelocationtype == 1)// LOCAL LINKED CSV FILES ONLY
				{	
					$csvfiledirectory = $target_path.$csvfilename;
					
					# LINK LOCATION - FULL PROCESSING 						
					$fileexists = file_exists($csvfiledirectory);
					
					if($fileexists == false)
					{
						echo 'CSV file not found';
					}
					elseif(!isAllowedExtension_wtg_csv2post($csvfiledirectory))
					{
						echo '<h2>Sorry a slight problem! Only CSV files are allowed please try again</h2>';
					}
					else
					{
						# DO MAIN PROCESS OF FILE AND DATA
						if($process == 1)
						{
							# FULL PROCESSING - $criteria1 IS FULL LOCATION
							$sqlQuery = "INSERT INTO " .
							$wpdb->prefix . "csvtopost_campaigns(camname, camfile, process, stage, locationtype)
							VALUES('$camname', '$csvfilename','$process','2','$filelocationtype')";
							$wpdb->query($sqlQuery);
							$camid = mysql_insert_id();
							$stage1complete = true;
						}
						elseif($process == 2)
						{
							# FULL PROCESSING - $criteria1 IS FULL LOCATION
							$sqlQuery = "INSERT INTO " .
							$wpdb->prefix . "csvtopost_campaigns(camname, camfile, process, ratio, stage, locationtype)
							VALUES('$camname', '$csvfilename','$process','$rowratio','2','$filelocationtype')";
							$wpdb->query($sqlQuery);
							$camid = mysql_insert_id();
							$stage1complete = true;
						}
					}
				}
				elseif($filelocationtype == 2)// UPLOADED CSV PROCESSING ONLY
				{	
					# UPLOAD LOCATION - FULL PROCESSING
					$fileArray = array();
					$file = $_FILES['csvupload'];
					
					if(empty($file))
					{ 
						echo '<h2>Sorry a slight problem! CSV file not found!</h2>';
					}
					elseif(!isAllowedExtension_wtg_csv2post($_FILES['csvupload']['name']))
					{
						echo '<h2>Sorry a slight problem! Only CSV files are allowed please try again</h2>';
					}
					else
					{		
						# PROCESS UPLOADED FILE AND STORE FILE NAME
						$csvfilename = basename( $_FILES['csvupload']['name'] );
						$csvfilename = str_replace(' ', '_', $csvfilename);
						$csvfilename = str_replace('-', '_', $csvfilename);
						$csvfilename = strtolower($csvfilename);
						$csvfilename = $camname . '_' . $csvfilename;// make new filename
						$target_path .= $csvfilename;
						$csvfiledirectory = $target_path;				
						move_uploaded_file($_FILES['csvupload']['tmp_name'], $target_path);
						
						if($process == 1)
						{
							# FULL PROCESSING - $criteria1 IS FULL LOCATION
							$sqlQuery = "INSERT INTO " .
							$wpdb->prefix . "csvtopost_campaigns(camname, camfile, process, stage, locationtype)
							VALUES('$camname', '$csvfilename','$process','2','$filelocationtype')";
							$wpdb->query($sqlQuery);
							$camid = mysql_insert_id();
							$stage1complete = true;
						}
						elseif($process == 2)
						{
							# FULL PROCESSING - $criteria1 IS FULL LOCATION
							$sqlQuery = "INSERT INTO " .
							$wpdb->prefix . "csvtopost_campaigns(camname, camfile, process, ratio, stage, locationtype)
							VALUES('$camname', '$csvfilename','$process','$rowratio','2','$filelocationtype')";
							$wpdb->query($sqlQuery);
							$camid = mysql_insert_id();
							$stage1complete = true;
						}
					}

					# GET ID OF LAST ENTRY  - ACTS AS CAMPAIGN ID
					$camid = mysql_insert_id();
				}
			}// check all required posts populated
		}// campaign name not empty and is string
	}

	# ONLY DISPLAY STAGE 1 FORM IF NOT COMPLETE
	if(!isset($stage1complete) || $stage1complete != true)
	{?>
		<h2>New Campaign  Stage 1 - Name and File</h2>
        
        <form enctype="multipart/form-data"  method="post" action="<?php $_SERVER['PHP_SELF']; ?>" name="new_campaign1">
            <label>Campaign Name:
            <input type="text" name="campaignname" id="campaignname" />*
            </label>
            <br />
            
            <h3>(a) Full or Staggered Processing</h3>
            <p>Select full will process the file all at once, not recommended unless you know your server/hosting will be ok with this!</p>
            
            <label>
            <input type="radio" name="processrate" value="1" id="ProcessRate_0" <?php if(get_option('full_trial_used_csv2post') == true){?>disabled="disabled"<?php }?> />
            Full - attempt to process entire file, may cause memory errors and is recommend for localhost use only.</label>
			<br />
            
            <label>
            <input type="radio" name="processrate" value="2" id="ProcessRate_1" />
            Staggered - </label>
            
            <label>Rows/Visit Ratio:
            <select name="rowratio" size="1">
                <option value="1">Create 1 Posts</option>
            </select> for every page visit!
            </label>
      Need a higher limit? <a href="http://www.webtechglobal.co.uk/wordpress-csv-2-post-plugin" title="Buy CSV 2 POST Plus" target="_blank">Buy CSV 2 POST Plus</a><br />
    
			<h3>(b) Upload or Link</h3>
            
             <label>
            <input type="radio" name="filelocationtype" value="1" id="filelocationtype_0" />
            Local File Name:</label>
            <input type="text" name="filelocationlocal" id="filelocationlocal" size="15" />
            Example: books.csv
			<br />
            
            <label>
            <input type="radio" name="filelocationtype" value="2" id="filelocationtype_1" />
            Upload: </label>
            
            <input type="file" name="csvupload" id="csvupload" size="40" />
            <?php $filelimit = ini_get( "upload_max_filesize"); echo $filelimit.' file size limit.'; ?>
            <br />
            
            <input name="stage" type="hidden" value="1" />
            <input name="page" type="hidden" value="new_campaign" />
            <input type="hidden" name="MAX_FILE_SIZE" value="90000000" />
            <input name="campaignsubmit" type="submit" value="Next Step" />
        </form>
        
		<?php
		
		echo $tutorial_url;
	}
}

# STAGE 2 RELATIONSHIPS - DISPLAY IF STAGE 1 IS COMPLETE OR STAGE 2 FORM ALREADY SUBMITTED
if((isset($_POST['stage']) && $_POST['stage'] == 2) || (isset($stage1complete) && $stage1complete == true))
{ 	
	# PROCESS STAGE 2 SUBMISSION THEN EITHER DISPLAY ERRORS OR GO TO STAGE 3
	if(!empty($_POST['matchsubmit']))
	{
		# STAGE 2 SUBMISSION MADE - PROCESS POST VARIABLES, THEY SHOULD BE POPULATED AND VALIDATED BEFORE THIS SUBMISSION
		$camid = $_POST['camid'];
		$csvfiledirectory = $_POST['csvfiledirectory'];
		$csvfile_columntotal = $_POST['csvfile_columntotal'];

		# ENTER CSV FILE COLUMN TOTAL TO MAIN CAMPAIGN TABLE FOR VALIDATION LATER
		global $wpdb;
		$sqlQuery = "UPDATE " .
		$wpdb->prefix . "csvtopost_campaigns SET csvcolumns = '$csvfile_columntotal' WHERE id = '$camid'";
		$wpdb->query($sqlQuery);
				
		$i = 0;
			
		foreach ( $_POST as $key => $postpart) 
		{
			# ENTER csv column TO post data MATCHES
			if($i < $csvfile_columntotal)
			{
				# THIS POST IS A COLUMN TO POST RELATIONSHIP
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_relationships(camid, csvcolumnid, postpart)
				VALUES('$camid', '$i','$postpart')";
				$wpdb->query($sqlQuery);
				
				# IF IS COLUMN FILTER ENTER TO wp_csvtopost_categories
				if($postpart == 'catfilter')
				{
					$sqlQuery = "INSERT INTO " .
					$wpdb->prefix . "csvtopost_relationships(camid, catcolumn)
					VALUES('$camid', '$i')";
					$wpdb->query($sqlQuery);				
				}
			}
			$i++;			
		}			
		$stage2complete = true;

		# UPDATE CAMPAIGN STAGE COUNTER
		$sqlQuery = "UPDATE " .
		$wpdb->prefix . "csvtopost_campaigns SET stage = '3' WHERE id = '$camid'";
		$wpdb->query($sqlQuery);
	}	

	# ONLY DISPLAY STAGE 2 FORM IF NOT COMPLETE
	if(!isset($stage2complete) || $stage2complete != true)
	{
		# GET NEW STAGE TO STAGE VARIABLES		
		if(!isset($camid))
		{
			echo 'Your campaigns ID is missing and it is required to continue in stage 2!';
		}
		
		if(!isset($csvfiledirectory))
		{
			echo 'Your csv file directory is missing and it is required to continue in stage 2!';
		}
		?>
        
        <h2> New Campaign  Stage 2 - Relationships</h2>
        </p>
        <p>Here you input settings that will configure your posts including matching your CSV file columns with parts of WordPress posts. I recommend you go to the bottom of this page and read further instructions&nbsp;on how best to do this.</p>

        <?php	
        # OPEN CSV FILE AGAIN
        $handle = fopen("$csvfiledirectory", "r");
		
		$stop = 0;
		
        while (($data = fgetcsv($handle, 999999, ",")) !== FALSE && $stop != 1)// Gets CSV rows
        {	 
			$stop++;// used to limit row parsing to just 1
			?>
            <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" name="new_campaign2">
                <table width="562">
                    <tr><td width="132"><h4>(ID)CSV Column Titles</h4></td><td width="46"></td><td width="258"><h4>Select WordPress Post Parts</h4></td></tr><?php
                   
				   $i = 0;
             
                    while(isset($data[$i]))
                    {
                        $data[$i] = rtrim($data[$i]);?>
                            <tr>
                                <td width="132"><?php echo $i . ' - ' . $data[$i]; ?></td>
                                <td width="46"></td>
                                <td width="258">
                                    <select name="posttypes<?php echo $i; ?>" size="1">
                                        <option value="title">Title</option>
                                        <option value="content">Content</option>
                                        <option value="currency">Currency</option>
                                        <option value="exclude" selected="selected">EXCLUDE</option>
                                        <option value="price">Price</option>
                                        <option value="advertiser">Advertiser</option>
                                        <option value="imageurl">Image URL</option>
                                        <option value="buyurl">Buy URL</option>
                                        <option value="category">Category</option>
                                        <option value="author">Author</option>
                                        <option value="publisher">Publisher</option>
                                    </select>
                                </td>
                            </tr><?php
                        $i++; // $i will equal number of columns - use to process submission
                    }
					
					$csvfile_columntotal = $i;
					?>
 
                    <input name="csvfile_columntotal" type="hidden" value="<?php echo $csvfile_columntotal; ?>" />
                    <input name="stage" type="hidden" value="2" />
                    <input name="page" type="hidden" value="new_campaign" />
                    <input name="csvfiledirectory" type="hidden" value="<?php echo $csvfiledirectory; ?>" />
                    <input name="camid" type="hidden" value="<?php echo $camid; ?>" />
    
                    <tr>
                        <td></td>
                        <td><input name="matchsubmit" type="submit" value="Submit" /></td>
                        <td></td>
                    </tr>
                
            	</table>
        </form>
        
		<?php
		
		echo $tutorial_url;
		
        }//end while rows
        
		fclose($handle);

	}//end if stage 2 submitted
}//end if stage 1 finished do stage 2

# STAGE 3 POST STATUS - DISPLAY IF STAGE 2 IS COMPLETE OR STAGE 3 FORM ALREADY SUBMITTED
if((isset($_POST['stage']) && $_POST['stage'] == 3) || (isset($stage2complete) && $stage2complete == true))
{
	# ALL REQUIRED VARIABLES SHOULD BE IN POST ELSE DISPLAY ERROR - 
	# FROM HERE ON THEY SHOULD CONSTANTLY BE IN POST STARTED FROM STAGE 2 SUBMISSION
	if(isset($_POST['camid']))
	{
		$camid = $_POST['camid'];
	}
	else
	{
		echo 'Your campaign id is missing and is required to continue on stage 3!';
	}

	if(isset($_POST['csvfiledirectory']))
	{
		$csvfiledirectory = $_POST['csvfiledirectory'];
	}
	else
	{
		echo 'Your csv file directory is missing and is required to continue on stage 3!';
	}
	
	if(isset($_POST['csvfile_columntotal']))
	{
		$csvfile_columntotal = $_POST['csvfile_columntotal'];
	}
	else
	{
		echo 'Your csv file column total is missing and is required to continue on stage 3!';
	}
	
	# PROCESS STAGE 3 SUBMISSION THEN EITHER DISPLAY ERRORS OR GO TO STAGE 4
	if(!empty($_POST['statussubmit']))
	{	
		if(!isset($_POST['poststatus']))
		{
			echo '<h3>You did not select a post status</h3>';
		}
		elseif(isset($_POST['poststatus']))
		{
			$status = $_POST['poststatus'];
			
			global $wpdb;
			
			# UPDATE CAMPAIGN STAGE COUNTER
			$sqlQuery = "UPDATE " .
			$wpdb->prefix . "csvtopost_campaigns SET stage = '4', poststatus = '$status' WHERE id = '$camid'";
			$wpdb->query($sqlQuery);
			$stage3complete = true;
		}
	}

	# ONLY DISPLAY STAGE 3 FORM IF NOT COMPLETE
	if(!isset($stage3complete) || $stage3complete != true)
	{?>

        <h2>New Campaign Stage 3 - Post Status</h2>
        <p>This stage is important if you do not want your created posts to be published without being checked first. Selecting PENDING or DRAFT will require someone to manually publish every post created!</p>
        <h3>Please Select A Post Status</h3>
        
        <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" name="new_campaign3">
        	<table>
                <tr>
                    <td>Publish</td>
                    <td><input type="radio" name="poststatus" value="publish" id="poststatus_0" /></td>
                    <td></td>
                </tr>     			
                
                <tr>
                    <td>Pending</td>
                    <td><input type="radio" name="poststatus" value="pending" id="poststatus_1" /></td>
                    <td></td>
                </tr>
                                    
                <tr>
                    <td>Draft </td>
                    <td><input type="radio" name="poststatus" value="draft" id="poststatus_2" /></td>
                    <td></td>
                </tr>
                               
                <tr>
                    <td></td>
                    <td><input name="statussubmit" type="submit" value="Submit" /></td>
                    <td></td>
                </tr>
            </table>

                    <input name="csvfile_columntotal" type="hidden" value="<?php echo $csvfile_columntotal; ?>" />
                    <input name="stage" type="hidden" value="3" />
                    <input name="page" type="hidden" value="new_campaign" />
                    <input name="csvfiledirectory" type="hidden" value="<?php echo $csvfiledirectory; ?>" />
                    <input name="camid" type="hidden" value="<?php echo $camid; ?>" />
        </form>
        
		<?php
		
		echo $tutorial_url;
	}
}


# STAGE 4 CUSTOM FIELDS - DISPLAY IF STAGE 3 IS COMPLETE OR STAGE 4 FORM ALREADY SUBMITTED
if((isset($_POST['stage']) && $_POST['stage'] == 4) || (isset($stage3complete) && $stage3complete == true))
{
	# ALL REQUIRED VARIABLES SHOULD BE IN POST ELSE DISPLAY ERROR	
	if(isset($_POST['camid']))
	{
		$camid = $_POST['camid'];
	}
	else
	{
		echo 'Your campaign id is missing and is required to continue on stage 4!';
	}

	if(isset($_POST['csvfiledirectory']))
	{
		$csvfiledirectory = $_POST['csvfiledirectory'];
	}
	else
	{
		echo 'Your csv file directory is missing and is required to continue on stage 4!';
	}
	
	if(isset($_POST['csvfile_columntotal']))
	{
		$csvfile_columntotal = $_POST['csvfile_columntotal'];
	}
	else
	{
		echo 'Your csv file column total is missing and is required to continue on stage 4!';
	}
		
	# PROCESS STAGE 4 SUBMISSION THEN EITHER DISPLAY ERRORS OR GO TO STAGE 4
	//this has been coded quickly without arrays and will be improved. I done this because 
	//development time and testing time is greatly shortened
	if(!empty($_POST['customfieldssubmit']))
	{		
		if(!empty($_POST['customfield1a']) && empty($_POST['customfield1b']))
		{
			echo '<h3>Sorry you did not enter an Assigned Value for the first row!</h3>';
		}
		elseif(empty($_POST['customfield1a']) && !empty($_POST['customfield1b']))
		{
			echo '<h3>Sorry you did not enter an Identified for the first row!</h3>';
		}
		elseif(!empty($_POST['customfield1a']) && !empty($_POST['customfield1b']))
		{
			$ident = $_POST['customfield1a'];
			$value = $_POST['customfield1b'];
			global $wpdb;
			$sqlQuery = "INSERT INTO " .
			$wpdb->prefix . "csvtopost_customfields(camid,identifier,value,type)
			VALUES('$camid','$ident','$value','0')";
			$wpdb->query($sqlQuery);
		}

		if(!empty($_POST['customfield2a']) && empty($_POST['customfield2b']))
		{
			echo '<h3>Sorry you did not enter an Assigned Value for the second row!</h3>';
		}
		elseif(empty($_POST['customfield2a']) && !empty($_POST['customfield2b']))
		{
			echo '<h3>Sorry you did not enter an Identified for the second row!</h3>';
		}
		elseif(!empty($_POST['customfield2a']) && !empty($_POST['customfield2b']))
		{
			$ident = $_POST['customfield2a'];
			$value = $_POST['customfield2b'];
			global $wpdb;
			$sqlQuery = "INSERT INTO " .
			$wpdb->prefix . "csvtopost_customfields(camid,identifier,value,type)
			VALUES('$camid','$ident','$value','0')";
			$wpdb->query($sqlQuery);
		}

		if(!empty($_POST['customfield3a']) && empty($_POST['customfield3b']))
		{
			echo '<h3>Sorry you did not enter an Assigned Value for the third row!</h3>';
		}
		elseif(empty($_POST['customfield3a']) && !empty($_POST['customfield3b']))
		{
			echo '<h3>Sorry you did not enter an Identified for the third row!</h3>';
		}
		elseif(!empty($_POST['customfield3a']) && !empty($_POST['customfield3b']))
		{
			$ident = $_POST['customfield3a'];
			$value = $_POST['customfield3b'];
			global $wpdb;
			$sqlQuery = "INSERT INTO " .
			$wpdb->prefix . "csvtopost_customfields(camid,identifier,value,type)
			VALUES('$camid','$ident','$value','0')";
			$wpdb->query($sqlQuery);
		}		
		
		# COLUMN PAIRED CUSTOM FIELDS BEGIN HERE
		if(!empty($_POST['customfield6a']) && !empty($_POST['customfield6b']))
		{
			$ident = $_POST['customfield6a'];
			$value = $_POST['customfield6b'];
			global $wpdb;
			$sqlQuery = "INSERT INTO " .
			$wpdb->prefix . "csvtopost_customfields(camid,identifier,value,type)
			VALUES('$camid','$ident','$value','1')";
			$wpdb->query($sqlQuery);
		}
		
		if(!empty($_POST['customfield7a']) && !empty($_POST['customfield7b']))
		{
			$ident = $_POST['customfield7a'];
			$value = $_POST['customfield7b'];
			global $wpdb;
			$sqlQuery = "INSERT INTO " .
			$wpdb->prefix . "csvtopost_customfields(camid,identifier,value,type)
			VALUES('$camid','$ident','$value','1')";
			$wpdb->query($sqlQuery);
		}

		if(!empty($_POST['customfield8a']) && !empty($_POST['customfield8b']))
		{
			$ident = $_POST['customfield8a'];
			$value = $_POST['customfield8b'];
			global $wpdb;
			$sqlQuery = "INSERT INTO " .
			$wpdb->prefix . "csvtopost_customfields(camid,identifier,value,type)
			VALUES('$camid','$ident','$value','1')";
			$wpdb->query($sqlQuery);
		}

		if(!empty($_POST['customfield9a']) && !empty($_POST['customfield9b']))
		{
			$ident = $_POST['customfield9a'];
			$value = $_POST['customfield9b'];
			global $wpdb;
			$sqlQuery = "INSERT INTO " .
			$wpdb->prefix . "csvtopost_customfields(camid,identifier,value,type)
			VALUES('$camid','$ident','$value','1')";
			$wpdb->query($sqlQuery);
		}
		
		$stage4complete = true;

		# UPDATE CAMPAIGN STAGE COUNTER
		$sqlQuery = "UPDATE " .
		$wpdb->prefix . "csvtopost_campaigns SET stage = '4' WHERE id = '$camid'";
		$wpdb->query($sqlQuery);
	}

	# ONLY DISPLAY STAGE 4 FORM IF NOT COMPLETE
	if(!isset($stage4complete) || $stage4complete != true)
	{?>

        <h2>New Campaign Stage 4 - Custom Fields</h2>
        <p>This is where you set Custom Fields for your posts and theme use. If no Custom Fields are required do not change anything and press submit. Please read further instructions below.</p>
        
        <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" name="new_campaign4">
        	<table>
            
                <tr>
                    <td></td>
                    <td><b>Identifier</b></td>
                    <td></td>
                    <td><b>Assigned Value</b></td>
                </tr>
                
                <tr>
                    <td>1</td>
                    <td><input name="customfield1a" type="text" value="" maxlength="30" /></td>
                    <td></td>
                    <td><input name="customfield1b" type="text" value="" maxlength="30" /></td>
                </tr>

                <tr>
                    <td>2</td>
                    <td><input name="customfield2a" type="text" value="" maxlength="30" /></td>
                    <td></td>
                    <td><input name="customfield2b" type="text" value="" maxlength="30" /></td>
                </tr>
                
                <tr>
                    <td>3</td>
                    <td><input name="customfield3a" type="text" value="" maxlength="30" /></td>
                    <td></td>
                    <td><input name="customfield3b" type="text" value="" maxlength="30" /></td>
                </tr>
                
                <!-- CUSTOM FIELDS MARRIED TO COLUMNS FOR UNIQUE VALUE ENTRY PER POST AFTER HERE -->

                <tr>
                    <td>4</td>
                    <td><input name="customfield6a" type="text" value="" maxlength="30" /></td>
                    <td></td>
                    <td><select name="customfield6b" size="1">      
					<?php
                    # CREATE MENU OF CSV FILE COLUMNS FOR MARRYING TO CUSTOM FIELD KEY
        			# OPEN CSV FILE AGAIN
                    $handle6 = fopen("$csvfiledirectory", "r");
					$stop = 0;
					$i = 0;
					while (($data = fgetcsv($handle6, 999999, ",")) !== FALSE && $stop != 1)// Gets CSV rows
                    {	 
                        $stop++;// used to limit row parsing to just 1
                    
                        $i = 0; 
                    
                        while(isset($data[$i]))
                        {
                            $data[$i] = rtrim($data[$i]);
                            
                            ?><option value="<?php echo $i; ?>"><?php echo $i . ' - ' . $data[$i]; ?></option><?php
                        
                            $i++; // $i will equal number of columns - use to process submission
                        }
                    }
                    
                    fclose($handle6);
                    ?>
                    </select></td>
                </tr>
                               
                <tr>
                    <td>5</td>
                    <td><input name="customfield7a" type="text" value="" maxlength="30" /></td>
                    <td></td>
                    <td><select name="customfield7b" size="1">      
					<?php
                    # CREATE MENU OF CSV FILE COLUMNS FOR MARRYING TO CUSTOM FIELD KEY
        			# OPEN CSV FILE AGAIN
                    $handle7 = fopen("$csvfiledirectory", "r");
					$stop = 0;
					$i = 0;
					while (($data = fgetcsv($handle7, 999999, ",")) !== FALSE && $stop != 1)// Gets CSV rows
                    {	 
                        $stop++;// used to limit row parsing to just 1
                    
                        $i = 0; 
                    
                        while(isset($data[$i]))
                        {
                            $data[$i] = rtrim($data[$i]);
                            
                            ?><option value="<?php echo $i; ?>"><?php echo $i . ' - ' . $data[$i]; ?></option><?php
                        
                            $i++; // $i will equal number of columns - use to process submission
                        }
                    }
                    
                    fclose($handle7);
                    ?>
                    </select></td>
                </tr>

                <tr>
                    <td>6</td>
                    <td><input name="customfield8a" type="text" value="" maxlength="30" /></td>
                    <td></td>
                    <td><select name="customfield8b" size="1">     
					<?php 
                    # CREATE MENU OF CSV FILE COLUMNS FOR MARRYING TO CUSTOM FIELD KEY 
        			# OPEN CSV FILE AGAIN
                    $handle8 = fopen("$csvfiledirectory", "r");
					$stop = 0;
					$i = 0;
                    while (($data = fgetcsv($handle8, 999999, ",")) !== FALSE && $stop != 1)// Gets CSV rows
                    {	 
                        $stop++;// used to limit row parsing to just 1
                    
                        $i = 0; 
                    
                        while(isset($data[$i]))
                        {
                            $data[$i] = rtrim($data[$i]);
                            
                            ?><option value="<?php echo $i; ?>"><?php echo $i . ' - ' . $data[$i]; ?></option><?php
                        
                            $i++; // $i will equal number of columns - use to process submission
                        }
                    }
					
                    fclose($handle8);
                    ?>
                    </select></td>
                </tr>
                
                <tr>
                    <td>7</td>
                    <td><input name="customfield9a" type="text" value="" maxlength="30" /></td>
                    <td></td>
                    <td><select name="customfield9b" size="1">      
					<?php
                    # CREATE MENU OF CSV FILE COLUMNS FOR MARRYING TO CUSTOM FIELD KEY  
        			# OPEN CSV FILE AGAIN
                    $handle9 = fopen("$csvfiledirectory", "r");
					$stop = 0;
					$i = 0;
					while (($data = fgetcsv($handle9, 999999, ",")) !== FALSE && $stop != 1)// Gets CSV rows
                    {	 
                        $stop++;// used to limit row parsing to just 1
                    
                        $i = 0; 
                    
                        while(isset($data[$i]))
                        {
                            $data[$i] = rtrim($data[$i]);
                            
                            ?><option value="<?php echo $i; ?>"><?php echo $i . ' - ' . $data[$i]; ?></option><?php
                        
                            $i++; // $i will equal number of columns - use to process submission
                        }
                    }

                    fclose($handle9);
                    ?>
                    </select></td>
                </tr>
                                
                <tr>
                    <td></td>
                    <td></td>
                    <td><input name="customfieldssubmit" type="submit" value="Submit" /></td>
                    <td></td>
                </tr>
                
    		</table>
            
                    <input name="csvfile_columntotal" type="hidden" value="<?php echo $csvfile_columntotal; ?>" />
                    <input name="stage" type="hidden" value="4" />
                    <input name="page" type="hidden" value="new_campaign" />
                    <input name="csvfiledirectory" type="hidden" value="<?php echo $csvfiledirectory; ?>" />
                    <input name="camid" type="hidden" value="<?php echo $camid; ?>" />
        </form>
        
		<?php
		
		echo $tutorial_url;
	}
}


# STAGE 5 CATEGORY FILTERING - DISPLAY IF STAGE 4 IS COMPLETE OR STAGE 5 FORM ALREADY SUBMITTED - STAGE 5 IS CATEGORY COLUMN SELECTION
if((isset($_POST['stage']) && $_POST['stage'] == 5) || (isset($stage4complete) && $stage4complete == true))
{
	# ALL REQUIRED VARIABLES SHOULD BE IN POST ELSE DISPLAY ERROR	
	if(isset($_POST['camid']))
	{
		$camid = $_POST['camid'];
	}
	else
	{
		echo 'Your campaign id is missing and is required to continue on stage 5!';
	}

	if(isset($_POST['csvfiledirectory']))
	{
		$csvfiledirectory = $_POST['csvfiledirectory'];
	}
	else
	{
		echo 'Your csv file directory is missing and is required to continue on stage 5!';
	}
	
	if(isset($_POST['csvfile_columntotal']))
	{
		$csvfile_columntotal = $_POST['csvfile_columntotal'];
	}
	else
	{
		echo 'Your csv file column total is missing and is required to continue on stage 5!';
	}

	# PROCESS STAGE 5 FIRST SUBMISSION FOR CATEGORY COLUMN SELECTION
	if(!empty($_POST['categoryfiltervalues']))
	{	
		$filtercolumn =	$_POST['optedfiltercolumn'];
		
		if($filtercolumn != 'NA')
		{
			if(!empty($_POST['cat1a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat1a'];
				$cat = $_POST['cat1b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
			
			if(!empty($_POST['cat2a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat2a'];
				$cat = $_POST['cat2b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
	
			if(!empty($_POST['cat3a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat3a'];
				$cat = $_POST['cat3b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}

			if(!empty($_POST['cat4a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat4a'];
				$cat = $_POST['cat4b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
 			if(!empty($_POST['cat5a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat5a'];
				$cat = $_POST['cat5b'];
				
				global $wpdb;
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
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
 			if(!empty($_POST['cat7a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat7a'];
				$cat = $_POST['cat7b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
 			if(!empty($_POST['cat7a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat7a'];
				$cat = $_POST['cat3b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
 			if(!empty($_POST['cat8a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat8a'];
				$cat = $_POST['cat8b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
 			if(!empty($_POST['cat9a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat9a'];
				$cat = $_POST['cat9b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
 			if(!empty($_POST['cat10a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat11a'];
				$cat = $_POST['cat11b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
 			if(!empty($_POST['cat12a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat12a'];
				$cat = $_POST['cat12b'];
				
				global $wpdb;
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
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
 			if(!empty($_POST['cat14a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat14a'];
				$cat = $_POST['cat14b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
 			if(!empty($_POST['cat15a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat15a'];
				$cat = $_POST['cat15b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
 			if(!empty($_POST['cat16a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat16a'];
				$cat = $_POST['cat16b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
 			if(!empty($_POST['cat17a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat17a'];
				$cat = $_POST['cat17b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
 			if(!empty($_POST['cat18a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat18a'];
				$cat = $_POST['cat18b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
 			if(!empty($_POST['cat19a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat19a'];
				$cat = $_POST['cat19b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
 			if(!empty($_POST['cat20a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat20a'];
				$cat = $_POST['cat20b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
 			if(!empty($_POST['cat21a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat21a'];
				$cat = $_POST['cat21b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
 			if(!empty($_POST['cat22a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat22a'];
				$cat = $_POST['cat22b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
 			if(!empty($_POST['cat23a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat23a'];
				$cat = $_POST['cat23b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
 			if(!empty($_POST['cat24a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat24a'];
				$cat = $_POST['cat24b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
 			if(!empty($_POST['cat25a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat25a'];
				$cat = $_POST['cat25b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
 			if(!empty($_POST['cat26a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat26a'];
				$cat = $_POST['cat26b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
 			if(!empty($_POST['cat27a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat27a'];
				$cat = $_POST['cat27b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
 			if(!empty($_POST['cat28a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat28a'];
				$cat = $_POST['cat28b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
 			if(!empty($_POST['cat29a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat29a'];
				$cat = $_POST['cat29b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
  			if(!empty($_POST['cat30a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat30a'];
				$cat = $_POST['cat30b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
  			if(!empty($_POST['cat31a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat31a'];
				$cat = $_POST['cat31b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
			
  			if(!empty($_POST['cat32a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat32a'];
				$cat = $_POST['cat32b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
			
  			if(!empty($_POST['cat33a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat33a'];
				$cat = $_POST['cat33b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
			
  			if(!empty($_POST['cat34a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat34a'];
				$cat = $_POST['cat34b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			}
			
  			if(!empty($_POST['cat35a']))
			{
				# SAVE TO CUSTOM FIELD TABLE
				$value = $_POST['cat35a'];
				$cat = $_POST['cat35b'];
				
				global $wpdb;
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_categories(camid,catid,uniquevalue)
				VALUES('$camid','$cat','$value')";
				$wpdb->query($sqlQuery);
			} 		
		}
		
		# UPDATE CAMPAIGN STAGE COUNTER
		global $wpdb;
		$sqlQuery = "UPDATE " .
		$wpdb->prefix . "csvtopost_campaigns SET filtercolumn = '$filtercolumn', stage = '5' WHERE id = '$camid'";
		$wpdb->query($sqlQuery);
		
		$stage5complete = true;
	}

	# ONLY DISPLAY STAGE 5 FORM IF NOT COMPLETE
	if(!isset($stage5complete) || $stage5complete != true)
	{?>

		<h2>New Campaign Stage 5 - Category Filtering</h2>
        <p>This part is very important and easy to get wrong. Until I create a better system, which is difficult when dealing with large CSV files, this must be done manually. Please read the instructions at the bottom of the page before continuing.</p>
        
        <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" name="new_campaign3">
        	<table>

                <tr>
                	<td></td>
                    <td><b>Selected Filter Column</b></td>
                    <td></td>
                    <td>
                    <?php					
					   $handle = fopen("$csvfiledirectory", "r");
						
						$stop = 0;
						
					   while (($data = fgetcsv($handle, 999999, ",")) !== FALSE && $stop != 1)// Gets CSV rows
						{	
							$stop++;// used to limit row parsing to just 1
				
							$i = 0; ?>
                            <select name="optedfiltercolumn" size="1">
                            <option value="999">Not Required</option><?php
							while(isset($data[$i]))
							{
								$data[$i] = rtrim($data[$i]);
                                
								?><option value="<?php echo $i; ?>"><?php echo $data[$i];?></option><?php
								
								$i++; // $i will equal number of columns - use to process submission
							}?></select><?php
						}
						
						fclose($handle);
						?>
                    
                    </td>
                </tr>
                
                <tr>
                	<td></td>
                    <td><b>Data Value</b></td>
                    <td></td>
                    <td><b>Category</b></td>
                </tr>

				<?php
				$number = 36;
				$count = 1;
				while($count != $number)
				{
					# ECHO A SET OF FILTER FIELDS ?>
                    <tr>
                    	<td><?php echo $count; ?>: </td>
                        <td><input name="cat<?php echo $count; ?>a" type="text" value="" maxlength="30" /></td>
                        <td></td>
                        <td><select name="cat<?php echo $count; ?>b" size="1"><?php get_categories_fordropdownmenu_wtg_csv2post();?></select></td>
                    </tr><?php 
					$count++;
				}
				?>
                
                <tr>
                    <td></td>
                    <td></td>
                    <td><input name="categoryfiltervalues" type="submit" value="Submit" /></td>
                    <td></td>
                </tr>
                
   		  </table>
          
            <input name="csvfile_columntotal" type="hidden" value="<?php echo $csvfile_columntotal; ?>" />
            <input name="stage" type="hidden" value="5" />
            <input name="page" type="hidden" value="new_campaign" />
            <input name="csvfiledirectory" type="hidden" value="<?php echo $csvfiledirectory; ?>" />
            <input name="camid" type="hidden" value="<?php echo $camid; ?>" />
        </form>
        
		<?php
		
		echo $tutorial_url;
	}
}

# STAGE 6 - DISPLAY IF STAGE 5 IS COMPLETE OR STAGE 5 FORM ALREADY SUBMITTED
if((isset($_POST['stage']) && $_POST['stage'] == 6) || (isset($stage5complete) && $stage5complete == true))
{
	# ALL REQUIRED VARIABLES SHOULD BE IN POST ELSE DISPLAY ERROR	
	if(isset($_POST['camid']))
	{
		$camid = $_POST['camid'];
	}
	else
	{
		echo 'Your campaign id is missing and is required to continue on stage 6!';
	}

	if(isset($_POST['csvfiledirectory']))
	{
		$csvfiledirectory = $_POST['csvfiledirectory'];
	}
	else
	{
		echo 'Your csv file directory is missing and is required to continue on stage 6!';
	}
	
	if(isset($_POST['csvfile_columntotal']))
	{
		$csvfile_columntotal = $_POST['csvfile_columntotal'];
	}
	else
	{
		echo 'Your csv file column total is missing and is required to continue on stage 6!';
	}
		
	# CAMPAIGN IS CREATED BUT DECIDE IF THIS CAMPAIGN CAN BE STARTED OR SET TO PAUSE AT THIS TIME
	global $wpdb;
	$count = $wpdb->get_var("SELECT COUNT(*) FROM " .$wpdb->prefix . "csvtopost_campaigns WHERE stage = '100'");

	if( $count > 0 )
	{
		# DO NOT SET THIS NEW CAMPAIGN TO 100, SET IT TOO 200 FOR PAUSED
		global $wpdb;
		$sqlQuery = "UPDATE " .
		$wpdb->prefix . "csvtopost_campaigns SET filtercolumn = '$filtercolumn', stage = '200' WHERE id = '$camid'";
		$wpdb->query($sqlQuery);
		?>
		<h2>New Campaign Stage 6 - Campaign Complete!</h2>
        <p>Your campaign has been saved but you currently have an active campaign. Only one campaign can run at a time. Please pause the other campaign on the Campaign Management screen or wait until it is finished.</p>
        <?php
	}
	else
	{
		# SET CAMPAIGN TO 100 AND MAKE ACTIVE AS THERE ARE NO OTHER CAMPAIGNS RUNNING AT THIS TIME
		global $wpdb;
		$sqlQuery = "UPDATE " .
		$wpdb->prefix . "csvtopost_campaigns SET filtercolumn = '$filtercolumn', stage = '100' WHERE id = '$camid'";
		$wpdb->query($sqlQuery);
		?>
		<h2>New Campaign Stage 6 - Campaign Complete!</h2>
        <p>Your campaign has been created and is already running. To pause it please go to the Campaign Management screen.</p>
        <?php
	}		
}
?>
  </p>
</p>
