<h2>CSV File Uploader <a href="http://www.csv2post.com/blog/instructions/csv-uploader-page" target="_blank"><img src="http://www.csv2post.com/images/question_small.png" width="35" height="35" alt="Get help for the CSV Uploader" /></a></h2>
<p>Upload your csv files here first before creating a new campaign. Many people attempt to use .txt or .xml files, these will not work. Please only upload Comma Seperated Value files when possible however your delimiter can differ, it is just good practice to use comma with CSV 2 POST.</p>

<?php
global $wpdb;

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
	$_POST = stripslashes_deep($_POST);
	
	$file = $_FILES['file'];
	
	if($_POST['action'] == 'upload') 
	{
		if ($file['error'] == 0) 
		{
			$filename = time() . '_' . $file['name'];
			
			$pathtofilename = csv2post_getcsvfilesdir() . $filename;
			move_uploaded_file($file['tmp_name'], $pathtofilename);
		
			if (file_exists(rtrim(ABSPATH, '/') . '/wp-content/csv2postfiles/' . $options['file'])) 
			{
				@unlink(rtrim(ABSPATH, '/') . '/wp-content/csv2postfiles/' . $options['file']);
			}
		
			$conf = File_CSV::discoverFormat($pathtofilename);
			$fields = File_CSV::read($pathtofilename, $conf);
			
			$fileChunks = explode(".", $filename);
     		$fileChunks[0];
			
			// create option using filename that will hold the delimiter - comma as default as its most common
			csv2post_createcsvprofile( $filename );// will create a new csv file profile with the new filename
			$csvprofileoption = csv2post_getcsvprofile( $filename );
			$profilename = csv2post_csvfilesprofilename($filename);
 
			if(!$conf && !$fields)
			{
				echo '<div id="message" class="updated fade"><p>File Not Uploaded - Either you attempted to upload a none .csv file or an error occured!</p></div>';
			}
			else
			{				
				if(isset($_POST['manualdelimiter']))
				{
					$csvprofileoption['format']['delimiter'] = $_POST['manualdelimiter'];
				}
				else
				{
					$csvprofileoption['format']['delimiter'] = ',';// default set as none submitted
				}
				echo '<div id="message" class="updated fade"><p>Success - CSV File Uploaded and renamed too ' . $filename . '</p></div>';
			}
			
			if(!$conf)
			{
				echo '<div id="message" class="updated fade"><p>Could not automatically scan file for details, please ensure you enter your delimiter for this csv file!</p></div>';
			}
			else
			{
				// update csv file delimiter if required
				if(isset($_POST['manualdelimiter']))
				{
					$csvprofileoption['format']['delimiter'] = $_POST['manualdelimiter'];
				}
				else
				{
					$csvprofileoption['format']['delimiter'] = $conf['sep'];
				}
				
				$csvprofileoption['format']['columns_pear'] = $conf['fields'];// add number of csv columns to profile
				$csvprofileoption['format']['quote_pear'] = $conf['quote'];// add  auto found quote to profile
				
				echo '<h3>CSV Format Detection</h3>';
				echo '<p>I detected ' . $conf['fields'] . ' columns in your csv file, if this is an incorrect number of columns then there was a problem counting them.</p>';
				echo '<p>Your csv data seperator has been automatically detected as ' . $conf['sep'] . '   If this is different from the one you thought please double check your csv file.';
				echo '<p>The quote used in your csv file is ' . $conf['quote'] . '  If you believe this is incorrect please double check in your csv file.';
			}
			if(!$fields)
			{
				echo '<div id="message" class="updated fade"><p>Could not read your first row of titles automatically!</p></div>';
			}
			else
			{
				echo '<h3>CSV Column Titles Detected</h3><p>If you do not see a vertical list of column names then there may be a problem!</p>';
				foreach($fields as $title)
				{
					echo '<p>' . $title . '</p>';
				}
			}				
		}
	}
	elseif($_POST['action'] == 'update')
	{
		echo '<div id="message" class="updated fade"><p>Your CSV File Settings Have Been Saved</p></div>';
	}	
	elseif($_POST['action'] == 'delete')
	{
		if($_POST['submitbutton'] == 'Delete')
		{	
			$filename = $_POST['csvfilename'];
					
			$full_filename = csv2post_getcsvfilesdir() . $filename;		
			
			if(!$filename)
			{
				echo '<div id="message" class="updated fade"><p>Sorry could not delete, filename not submitted</p></div>';
			}
			else
			{
				$user_count = $wpdb->get_var("SELECT COUNT(*) FROM " .$wpdb->prefix . "csv2post_campaigns WHERE camfile = '$filename'");
				
				if($user_count >= 1)
				{
					echo '<div id="message" class="updated fade"><p>Cannot delete, currently in use! Please delete the campaign using it then try again.</p></div>';
				}
				else
				{
					$delete =  @unlink($full_filename);
					
					if(!$delete)
					{
						echo '<div id="message" class="updated fade"><p>Sorry there was a problem deleting your CSV file!</p></div>';
					}
					elseif($delete)
					{
						// delete csv profile details from database
						$user_count = $wpdb->get_var("DELETE FROM " .$wpdb->prefix . "csv2post_layouts WHERE csvfile = '$filename'");
						delete_option($profilename);
						echo '<div id="message" class="updated fade"><p>CSV file deleted successfully:' . $filename . '</p></div>';
					}
				}
			}
		}		
	}
	
	// apply any changes made to csv profile
	update_option( $profilename, $csvprofileoption );				
} 
?>
		<form method="post" enctype="multipart/form-data" name="uploadform" class="form-table">
			<input type="hidden" name="action" value="upload" />
			<div id="poststuff">
				<div id="datafeed-upload" class="postbox">
					<h3 class='hndle'><span>Upload New CSV File</span></h3>
					<div class="inside" style="padding:20px;">
					 	 <input type="file" name="file" size="40" /><?php $filelimit = ini_get( "upload_max_filesize"); echo $filelimit.'B file size limit,upload by ftp if larger '.$filelimit.'B.'; ?>
					  	<br />
                        <input name="manualdelimiter" type="text" size="1" maxlength="1" /> 
                        Please Enter File Delimiter
					    <p class="submit"><input class="button-primary" type="submit" value="Submit" /></p>
					</div>
				</div>
			</div>
		</form>
        
        
  		<form method="post" name="csvfiledelete" class="form-table">
			<div id="poststuff">
				<div id="datafeed-upload" class="postbox">
				  <h3 class='hndle'><span>Delete Unused CSV Files</span></h3>
						<?php
                        $csv_extension = 'csv';
                        
                        $csvfiles_dir2 = csv2post_getcsvfilesdir();
                        $csvfiles_diropen2 = opendir($csvfiles_dir2);
                        
                        $i = 0;
                        
                        while(false != ($csvfiles = readdir($csvfiles_diropen2)))
                        {
                            $i++;
                            
                            if(($csvfiles != ".") and ($csvfiles != ".."))
                            {
                                $fileChunks = explode(".", $csvfiles);
                                
                                if($fileChunks[1] == $csv_extension) //interested in second chunk only
                                { 	?>
                                    <label><input type="radio" name="csvfilename" value="<?php echo $csvfiles;?>" /><?php echo $csvfiles;?></label><br />
                                    <?php
                                }
                            }
                        }
                                                
                        if( $i == 2 ){ echo '<h4>No CSV Files Found</h4>';}
                        
                        closedir($csvfiles_diropen2); 
                        ?>
                       <input type="hidden" name="action" value="delete" />
                        <p class="submit"><input class="button-primary" type="submit" name="submitbutton" value="Delete" /></p>
                </div>
            </div>
	    </form>	      
       
<p><strong>CSV Files Folder Status:</strong> <?php echo csv2post_doesexist_csvfilesfolder(); ?></p>

<br />

<h2>CSV Uploader Tutorial</h2>
<object width="566" height="510"><param name="movie" value="http://www.youtube.com/v/QoefK2TDgic&hl=en&fs=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/QoefK2TDgic&hl=en&fs=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="566" height="510"></embed></object>