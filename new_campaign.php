<?php
# DEBUG DURING DEVELOPMENT
define('WP_DEBUG',true);

global $wpdb;

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
			$count = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->csvtopost_campaigns WHERE camname = '$name'");
			
			if( $count > 0 )
			{
				echo '<h2>Your campaign name is used, please try something different</h2>';
			}
			else
			{
				# ENSURE ALL REQUIRED OPTIONS SELECTED AND COMPLETE
				if(empty($_POST['processrate']))
				{
					echo 'Sorry no process rate selected';
				}
				elseif(!empty($_POST['processrate']) && $_POST['processrate'] == 2 && empty($_POST['rowratio']))
				{
					echo 'Sorry you did not enter Row/Visitor ratio number';
				}
				elseif(!empty($_POST['processrate']) && empty($_POST['filelocationtype']))
				{
					echo 'Please select a file location type';	
				}
				elseif(!empty($_POST['processrate']) && !empty($_POST['filelocationtype']) && $_POST['filelocationtype'] == 1 && empty($_POST['filelocationlocal']))
				{
					echo 'You selected Link for your CSV file location type but did not provide the URL to your file';
				}	
				elseif(!empty($_POST['processrate']) && !empty($_POST['filelocationtype']) && $_POST['filelocationtype'] == 2 && empty($_FILES['csvupload']))
				{
					echo 'You selected Upload for your CSV file location type but did not browse and select your CSV file!';
				}
				else
				{
					# ALL REQUIRED DETAILS CAPTURED SO NOW PROCESS
					$camname = $_POST['campaignname'];
					$process = $_POST['processrate'];
					$rowratio = $_POST['rowratio'];
					$filelocationlocal = $_POST['filelocationlocal'];
					$filelocationtype = $_POST['filelocationtype'];

					$target_path = dirname(__FILE__).'/csv_files/'; // Upload store directory (chmod 777)

					# CALL UPLOAD PROCESS FUNCTION PASSING REQUIRED VALUES ONLY
					if($filelocationtype == 1)// LOCAL LINKED CSV FILES ONLY
					{	
						$csvdirectory = $filelocationlocal;

						# LINK LOCATION - FULL PROCESSING 						
						$fileexists = file_exists($csvdirectory);
						
						if($fileexists == false)
						{
							echo 'CSV file not found';
						}
						elseif(!isAllowedExtension($csvdirectory))
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
								$wpdb->prefix . "csvtopost_campaigns(camname, process, stage, csvrows, locationtype, location)
								VALUES('$camname', '$process','2','$rowtotal','$filelocationtype','$csvdirectory')";
								$wpdb->query($sqlQuery);
								$_SESSION['wtg_csv2post_camid'] = mysql_insert_id();//get new post id just created
								$stage1complete = true;
							}
							elseif($process == 2)
							{
								# FULL PROCESSING - $criteria1 IS FULL LOCATION
								$sqlQuery = "INSERT INTO " .
								$wpdb->prefix . "csvtopost_campaigns(camname, process, ratio, stage, csvrows, locationtype, location)
								VALUES('$camname', '$process','$rowratio','2','$rowtotal','$filelocationtype','$csvdirectory')";
								$wpdb->query($sqlQuery);
								$_SESSION['wtg_csv2post_camid'] = mysql_insert_id();//get new post id just created
								$stage1complete = true;
							}
						}
					}
					elseif($filelocationtype == 2)// UPLOADED CSV PROCESSING ONLY
					{	
						# UPLOAD LOCATION - FULL PROCESSING
						$fileArray = array();
						$file = $_FILES['csvupload'];
						$fileName = $_FILES['csvupload']['name'];
						$basename = '';
						
						if(empty($fileName))
						{ 
							echo '<h2>Sorry a slight problem!  CSV file not found!</h2>';
						}
						elseif(!isAllowedExtension($_FILES['csvupload']['name']))
						{
							echo '<h2>Sorry a slight problem! Only CSV files are allowed please try again</h2>';
						}
						else
						{		
							# DO MAIN PROCESS OF FILE AND DATA
							$basename = basename( $_FILES['csvupload']['name'] );
							$basename = str_replace(' ', '_', $basename);
							$basename = str_replace('-', '_', $basename);
							$basename = strtolower($basename);
							$basename = $camname . '_' . $basename;// make new filename
							$target_path .= $basename;
							
							move_uploaded_file($_FILES['csvupload']['tmp_name'], $target_path);
				
							$csvdirectory = $target_path;

							if($process == 1)
							{
								# FULL PROCESSING - $criteria1 IS FULL LOCATION
								$sqlQuery = "INSERT INTO " .
								$wpdb->prefix . "csvtopost_campaigns(camname, camfile, process, stage, csvrows, locationtype)
								VALUES('$camname', '$basename','$process','2','$rowtotal','$filelocationtype')";
								$wpdb->query($sqlQuery);
								$_SESSION['wtg_csv2post_camid'] = mysql_insert_id();//get new post id just created
								$stage1complete = true;
							}
							elseif($process == 2)
							{
								# FULL PROCESSING - $criteria1 IS FULL LOCATION
								$sqlQuery = "INSERT INTO " .
								$wpdb->prefix . "csvtopost_campaigns(camname, camfile, process, ratio, stage, csvrows, locationtype)
								VALUES('$camname', '$basename','$process','$rowratio','2','$rowtotal','$filelocationtype')";
								$wpdb->query($sqlQuery);
								$_SESSION['wtg_csv2post_camid'] = mysql_insert_id();//get new post id just created
								$stage1complete = true;
							}
						}

						# GET ID OF LAST ENTRY  - ACTS AS CAMPAIGN ID
						$_SESSION['wtg_csv2post_camid'] = mysql_insert_id();
					}
				}// check all required posts populated
			}// if campaign name exists or not
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
            <input type="radio" name="processrate" value="1" id="ProcessRate_0" />
            Full - 100% of the file will be processed all at once</label>
			<br />
            
            <label>
            <input type="radio" name="processrate" value="2" id="ProcessRate_1" />
            Staggered - </label>
            
            <label>Rows/Visitor Ratio:
            <input type="text" name="rowratio" id="rowratio" size="5" />
            </label>
            <br />
    
			<h3>(b) Upload or Link</h3>
            
             <label>
            <input type="radio" name="filelocationtype" value="1" id="filelocationtype_0" />
            Link:</label>
            <input type="text" name="filelocationlocal" id="filelocationlocal" size="50" />
			<br />
            
            <label>
            <input type="radio" name="filelocationtype" value="2" id="filelocationtype_1" />
            Upload: </label>
            
            <input type="file" name="csvupload" id="csvupload" size="40" />*
            <br />
            
            <input name="stage" type="hidden" value="1" />
            <input name="page" type="hidden" value="new_campaign" />
            <input type="hidden" name="MAX_FILE_SIZE" value="90000000" />
            <input name="campaignsubmit" type="submit" value="Next Step" />
        </form>
		
        <?php include('instructions/stage1.php');
	}
}

# STAGE 2 - DISPLAY IF STAGE 1 IS COMPLETE OR STAGE 2 FORM ALREADY SUBMITTED
if((isset($_POST['stage']) && $_POST['stage'] == 2) || (isset($stage1complete) && $stage1complete == true))
{ 
	# GET POSTED DATA THAT IS STILL NEEDED THROUGHOUT SCRIPT	
	if(isset($_POST['csvdirectory']))// real file path
	{
		$csvdirectory = $_POST['csvdirectory'];
	}
	elseif(isset($_SESSION['wtg_csvtopost_csvdirectory']))
	{
		$csvdirectory = $_SESSION['wtg_csvtopost_csvdirectory']; 
	}
	
	if(isset($_POST['camid']))
	{
		$camid = $_POST['camid'];
	}
	elseif(isset($_SESSION['wtg_csv2post_camid']))
	{
		$camid = $_SESSION['wtg_csv2post_camid']; 
	}
		
	# PROCESS STAGE 2 SUBMISSION THEN EITHER DISPLAY ERRORS OR GO TO STAGE 3
	if(!empty($_POST['matchsubmit']))
	{
		# STAGE 2 SUBMISSION MADE - PROCESS ASSUMES THE VISIBLE FORM DROP DOWNS ARE FIRST
		$csvcolumns = $_POST['csvfilecolumntotal']; // total number of columns in csv file
		$camid = $_POST['camid']; // campaign id
		$poststatus = $_POST['poststatus']; //publish,draft,pending
		
		# ENTER CSV FILE COLUMN TOTAL TO MAIN CAMPAIGN TABLE FOR VALIDATION LATER
		global $wpdb;
		$sqlQuery = "UPDATE " .
		$wpdb->prefix . "csvtopost_campaigns SET csvcolumns = '$csvcolumns' WHERE id = '$camid'";
		$wpdb->query($sqlQuery);
				
		$i = 0;
			
		foreach ( $_POST as $key => $postpart) 
		{
			$csvcolumn_id = $i; // enter this into database row
						
			# ENTER csv column TO post data MATCHES
			if($i < $csvcolumns)
			{
				# THIS POST IS A COLUMN TO POST RELATIONSHIP
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_relationships(camid, csvcolumnid, postpart)
				VALUES('$camid', '$csvcolumn_id','$postpart')";
				$wpdb->query($sqlQuery);
				
				# IF IS COLUMN FILTER ENTER TO wp_csvtopost_categories
				if($postpart == 'catfilter')
				{
					$sqlQuery = "INSERT INTO " .
					$wpdb->prefix . "csvtopost_relationships(camid, catcolumn)
					VALUES('$camid', '$csvcolumn_id')";
					$wpdb->query($sqlQuery);				
				}
			}
			$i++;			
		}			
		$stage2complete = true;

		# UPDATE CAMPAIGN STAGE COUNTER
		$sqlQuery = "UPDATE " .
		$wpdb->prefix . "csvtopost_campaigns SET stage = '3', poststatus = '$poststatus' WHERE id = '$camid'";
		$wpdb->query($sqlQuery);
	}	

	# ONLY DISPLAY STAGE 2 FORM IF NOT COMPLETE
	if(!isset($stage2complete) || $stage2complete != true)
	{?>
        <h2> New Campaign  Stage 2 - Relationships</h2>
        </p>
        <p>Here you input settings that will configure your posts including matching your CSV file columns with parts of WordPress posts. I recommend you go to the bottom of this page and read further instructions&nbsp;on how best to do this.</p>

        <?php
        //open csv file associated with campaign being created
        $handle = fopen("$csvdirectory", "r");
						
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
                                    </select>
                                </td>
                            </tr><?php
                        $i++; // $i will equal number of columns - use to process submission
                    }?>
 
                    <?php wtg_csvtopost_constantvalues($i,2,$filename,$csvdirectory,$camid);?>

                    <tr>
                        <td></td>
                        <td><input name="matchsubmit" type="submit" value="Submit" /></td>
                        <td></td>
                    </tr>
                
            	</table>
			</form>
		<?php 
        }//end while rows
        
		fclose($handle);
		
		include('instructions/stage2.php');

	}//end if stage 2 submitted
}//end if stage 1 finished do stage 2

# STAGE 3 - DISPLAY IF STAGE 2 IS COMPLETE OR STAGE 3 FORM ALREADY SUBMITTED
if((isset($_POST['stage']) && $_POST['stage'] == 3) || (isset($stage2complete) && $stage2complete == true))
{
	# GET POSTED DATA THAT IS STILL NEEDED THROUGHOUT SCRIPT	
	if(isset($_POST['csvdirectory']))// real file path
	{
		$csvdirectory = $_POST['csvdirectory'];
	}
	elseif(isset($_SESSION['wtg_csvtopost_csvdirectory']))
	{
		$csvdirectory = $_SESSION['wtg_csvtopost_csvdirectory']; 
	}
	
	if(isset($_POST['camid']))
	{
		$camid = $_POST['camid'];
	}
	elseif(isset($_SESSION['wtg_csv2post_camid']))
	{
		$camid = $_SESSION['wtg_csv2post_camid']; 
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

            <?php wtg_csvtopost_constantvalues($i,3,$filename,$csvdirectory,$camid);?>

        </form><?php

		include('instructions/stage3.php');

	}
}


# STAGE 4 - DISPLAY IF STAGE 3 IS COMPLETE OR STAGE 4 FORM ALREADY SUBMITTED
if((isset($_POST['stage']) && $_POST['stage'] == 4) || (isset($stage3complete) && $stage3complete == true))
{
	# GET POSTED DATA THAT IS STILL NEEDED THROUGHOUT SCRIPT
	if(isset($_POST['filename']))// file name only not directory
	{
		$filename = $_POST['filename'];
	}
	elseif(isset($_SESSION['wtg_csvtopost_filename']))
	{
		$filename = $_SESSION['wtg_csvtopost_filename']; 
	}
	
	if(isset($_POST['csvdirectory']))// real file path
	{
		$csvdirectory = $_POST['csvdirectory'];
	}
	elseif(isset($_SESSION['wtg_csvtopost_csvdirectory']))
	{
		$csvdirectory = $_SESSION['wtg_csvtopost_csvdirectory']; 
	}
	
	if(isset($_POST['camid']))
	{
		$camid = $_POST['camid'];
	}
	elseif(isset($_SESSION['wtg_csv2post_camid']))
	{
		$camid = $_SESSION['wtg_csv2post_camid']; 
	}
		
	# PROCESS STAGE 4 SUBMISSION THEN EITHER DISPLAY ERRORS OR GO TO STAGE 4
	//this has been coded quickly without arrays and will be improved. I done this because 
	//development time and testing time is greatly shortened
	if(!empty($_POST['customfieldssubmit']))
	{		
		if(isset($_POST['customfield1a']) && !isset($_POST['customfield1b']))
		{
			echo '<h3>Sorry you did not enter an Assigned Value for the first row!</h3>';
		}
		elseif(!isset($_POST['customfield1a']) && isset($_POST['customfield1b']))
		{
			echo '<h3>Sorry you did not enter an Identified for the first row!</h3>';
		}
		elseif(isset($_POST['customfield1a']) && isset($_POST['customfield1b']))
		{
			$ident = $_POST['customfield1a'];
			$value = $_POST['customfield1b'];
			global $wpdb;
			$sqlQuery = "INSERT INTO " .
			$wpdb->prefix . "csvtopost_customfields(camid,identifier,value,type)
			VALUES('$camid','$ident','$value','0')";
			$wpdb->query($sqlQuery);
		}

		if(isset($_POST['customfield2a']) && !isset($_POST['customfield2b']))
		{
			echo '<h3>Sorry you did not enter an Assigned Value for the second row!</h3>';
		}
		elseif(!isset($_POST['customfield2a']) && isset($_POST['customfield2b']))
		{
			echo '<h3>Sorry you did not enter an Identified for the second row!</h3>';
		}
		elseif(isset($_POST['customfield2a']) && isset($_POST['customfield2b']))
		{
			$ident = $_POST['customfield2a'];
			$value = $_POST['customfield2b'];
			global $wpdb;
			$sqlQuery = "INSERT INTO " .
			$wpdb->prefix . "csvtopost_customfields(camid,identifier,value,type)
			VALUES('$camid','$ident','$value','0')";
			$wpdb->query($sqlQuery);
		}

		if(isset($_POST['customfield3a']) && !isset($_POST['customfield3b']))
		{
			echo '<h3>Sorry you did not enter an Assigned Value for the third row!</h3>';
		}
		elseif(!isset($_POST['customfield3a']) && isset($_POST['customfield3b']))
		{
			echo '<h3>Sorry you did not enter an Identified for the third row!</h3>';
		}
		elseif(isset($_POST['customfield3a']) && isset($_POST['customfield3b']))
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
		if(isset($_POST['customfield7a']) && isset($_POST['customfield7b']))
		{
			$ident = $_POST['customfield7a'];
			$value = $_POST['customfield7b'];
			global $wpdb;
			$sqlQuery = "INSERT INTO " .
			$wpdb->prefix . "csvtopost_customfields(camid,identifier,value,type)
			VALUES('$camid','$ident','$value','1')";
			$wpdb->query($sqlQuery);
		}

		if(isset($_POST['customfield8a']) && isset($_POST['customfield8b']))
		{
			$ident = $_POST['customfield8a'];
			$value = $_POST['customfield8b'];
			global $wpdb;
			$sqlQuery = "INSERT INTO " .
			$wpdb->prefix . "csvtopost_customfields(camid,identifier,value,type)
			VALUES('$camid','$ident','$value','1')";
			$wpdb->query($sqlQuery);
		}

		if(isset($_POST['customfield9a']) && isset($_POST['customfield9b']))
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
                    <td><input name="customfield7a" type="text" value="" maxlength="30" /></td>
                    <td></td>
                    <td><select name="customfield7b" size="1">      
					<?php
                    # CREATE MENU OF CSV FILE COLUMNS FOR MARRYING TO CUSTOM FIELD KEY
                    $handle7 = fopen("$csvdirectory", "r");
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
                    <td>5</td>
                    <td><input name="customfield8a" type="text" value="" maxlength="30" /></td>
                    <td></td>
                    <td><select name="customfield8b" size="1">     
					<?php 
                    # CREATE MENU OF CSV FILE COLUMNS FOR MARRYING TO CUSTOM FIELD KEY 
                    $handle8 = fopen("$csvdirectory", "r");
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
                    <td>6</td>
                    <td><input name="customfield9a" type="text" value="" maxlength="30" /></td>
                    <td></td>
                    <td><select name="customfield9b" size="1">      
					<?php
                    # CREATE MENU OF CSV FILE COLUMNS FOR MARRYING TO CUSTOM FIELD KEY   
                    $handle9 = fopen("$csvdirectory", "r");
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
            
			<?php wtg_csvtopost_constantvalues($i,4,$filename,$csvdirectory,$camid);?>

        </form><?php
		
		include('instructions/stage4.php');
	}
}


# STAGE 5 - DISPLAY IF STAGE 4 IS COMPLETE OR STAGE 5 FORM ALREADY SUBMITTED - STAGE 5 IS CATEGORY COLUMN SELECTION
if((isset($_POST['stage']) && $_POST['stage'] == 5) || (isset($stage4complete) && $stage4complete == true))
{
	# GET POSTED DATA THAT IS STILL NEEDED THROUGHOUT SCRIPT
	if(isset($_POST['csvdirectory']))// real file path
	{
		$csvdirectory = $_POST['csvdirectory'];
	}
	elseif(isset($_SESSION['wtg_csvtopost_csvdirectory']))
	{
		$csvdirectory = $_SESSION['wtg_csvtopost_csvdirectory']; 
	}
	
	if(isset($_POST['camid']))
	{
		$camid = $_POST['camid'];
	}
	elseif(isset($_SESSION['wtg_csv2post_camid']))
	{
		$camid = $_SESSION['wtg_csv2post_camid']; 
	}

	# PROCESS STAGE 5 FIRST SUBMISSION FOR CATEGORY COLUMN SELECTION
	if(!empty($_POST['categoryfiltervalues']))
	{	
		$filtercolumn =	$_POST['optedfiltercolumn'];
		
		if($filtercolumn != 'NA')
		{
			if(isset($_POST['cat1a']))
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
			
			if(isset($_POST['cat2a']))
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
	
			if(isset($_POST['cat3a']))
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
		}
		
		# UPDATE CAMPAIGN STAGE COUNTER
		global $wpdb;
		$sqlQuery = "UPDATE " .
		$wpdb->prefix . "csvtopost_campaigns SET filtercolumn = '$filtercolumn', stage = '100' WHERE id = '$camid'";
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
					   $handle = fopen("$csvdirectory", "r");

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
                        <td><input name="cat<?php echo $count; ?>" type="text" value="" maxlength="30" /></td>
                        <td></td>
                        <td><select name="cat<?php echo $count; ?>b" size="1"><?php get_categories_fordropdownmenu();?></select></td>
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
          
          <?php wtg_csvtopost_constantvalues($i,5,$filename,$csvdirectory,$camid);?>

        </form><?php
		
		include('instructions/stage5.php');
	}
}

# STAGE 6 - DISPLAY IF STAGE 5 IS COMPLETE OR STAGE 5 FORM ALREADY SUBMITTED
if((isset($_POST['stage']) && $_POST['stage'] == 100) || (isset($stage5complete) && $stage5complete == true))
{
	# GET POSTED DATA THAT IS STILL NEEDED THROUGHOUT SCRIPT
	if(isset($_POST['csvdirectory']))// real file path
	{
		$csvdirectory = $_POST['csvdirectory'];
	}
	elseif(isset($_SESSION['wtg_csvtopost_csvdirectory']))
	{
		$csvdirectory = $_SESSION['wtg_csvtopost_csvdirectory']; 
	}
	
	if(isset($_POST['camid']))
	{
		$camid = $_POST['camid'];
	}
	elseif(isset($_SESSION['wtg_csv2post_camid']))
	{
		$camid = $_SESSION['wtg_csv2post_camid']; 
	}
		
	# PROCESS STAGE 3 SUBMISSION THEN EITHER DISPLAY ERRORS OR GO TO STAGE 4
	if(!empty($_POST['statussubmit']))
	{		
		$stage6complete = true;
	}

	# ONLY DISPLAY STAGE 1 FORM IF NOT COMPLETE
	if(!isset($stage6complete) || $stage6complete != true)
	{	?>
		<h2>New Campaign Stage 6 - Campaign Complete!</h2>
        <p>Your campaign has started! If you selected FULL processing your entire CSV file will be injected into your blog right now.</p>
		<?php
		include('instructions/stage6.php');
	}
}
?>
  </p>
</p>
