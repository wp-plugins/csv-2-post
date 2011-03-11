<?php
# Page Include Functions
function c2pf_toppage(){require_once(C2PPATH.'/c2pf_home.php');}
function c2pf_subpage2(){require_once(C2PPATH.'/c2pf_speeds.php');}
function c2pf_subpage3(){require_once(C2PPATH.'/c2pf_overview.php');}
function c2pf_subpage4(){require_once(C2PPATH.'/c2pf_designs.php');}
function c2pf_subpage5(){require_once(C2PPATH.'/c2pf_start.php');}
function c2pf_subpage6(){require_once(C2PPATH.'/c2pf_configs.php');}
function c2pf_subpage7(){require_once(C2PPATH.'/c2pf_settings.php');}
function c2pf_subpage8(){require_once(C2PPATH.'/c2pf_log.php');}

# Adds Admin Menu
function c2pf_menu() 
{
	$set = get_option( 'c2pf_set' );

	// set permission level for all csv2post pages	
	add_menu_page('CSV2POST Free', 'CSV2POST Free', C2PAUTHLEV, __FILE__ , 'c2pf_toppage');
	add_submenu_page( __FILE__ , '1. Start', '1. Start', C2PAUTHLEV, 'c2pf_start', 'c2pf_subpage5');
	add_submenu_page( __FILE__ , '2. WYSIWYG Designs', '2. WYSIWYG Designs', C2PAUTHLEV, 'c2pf_designs', 'c2pf_subpage4');
	add_submenu_page( __FILE__ , '3. Event Speeds', '3. Event Speeds', C2PAUTHLEV, 'c2pf_spe', 'c2pf_subpage2');
	add_submenu_page( __FILE__ , '4. Project Config', '4. Project Config', C2PAUTHLEV, 'c2pf_configs', 'c2pf_subpage6');
	add_submenu_page( __FILE__ , '5. Project Overview', '5. Project Overview', C2PAUTHLEV, 'c2pf_overview', 'c2pf_subpage3');
	add_submenu_page( __FILE__ , 'Plugin Settings', 'Plugin Settings', C2PAUTHLEV, 'c2pf_settings', 'c2pf_subpage7');
	add_submenu_page( __FILE__ , 'Log', 'Log', C2PAUTHLEV, 'c2pf_log', 'c2pf_subpage8');
}

// hooks actions and triggers
add_action('admin_menu', 'c2pf_menu');

# Processes CSV File Upload For Overwriting Old File Only
function c2pf_csvuploadupdate( $upload )
{
	$set = get_option( 'c2pf_set' );
	
	// check for errors
	if ( $upload['error'] != 0 ) 
	{
		c2pf_log( 'Upload Failed','A file upload for overwriting existing file failed','Operation',$set,'Failure' );	
		c2pf_error('CSV File Upload Failed','CSV file upload could not be started at all as the file loader returned error, please try again.');
	}
	elseif ( $upload['error'] == 0 ) 
	{	
		// get project data
		$pro = get_option('c2pf_pro');
		
		// confirm filename is a match to an existing project else stop the upload		
		if( !isset( $pro[$upload['name']] ) )
		{
			c2pf_err( 'Uploaded File Does Not Match Any Project','The file you uploaded is named '. $upload['name'] .' and no
			project was found with that name. Please go to the Project Start page if you are trying to setup a new project or
			correct the filename to match your existing projects filename so that it overwrites the existing file.' );
		}
		elseif( isset( $pro[$upload['name']] ) )
		{
			// is the uploaded file for current project or different project ( we still complete the upload )
			if( $upload['name'] == $pro['current'] )
			{
				c2pf_mes( 'File Matches Current Project','The plugin confirmed that the csv file being uploaded is for the project you are current working on, the old file has been overwritten.' );
			}
			else
			{
				c2pf_mes( 'File Matches Another Project','The plugin will continue to upload your csv file
						and any matching file will be overwritten however the file you are uploading is not for
						the current active project. This does not mean that your current project will use the data
						from the file you have uploaded. This message is just to confirm that you have not uploaded
						a new csv file for the project you are currently working on. Your active project has not been
						changed in any way. ' );
			}
			
			// get the path to the existing project file - used as final path
			$path = $pro[$upload['name']]['filepath'];
			
			// confirm file is actually there and delete, it may already be deleted
			if ( file_exists( $path ) ) 
			{
				// change file exists switch to true
				$fileexisted = true;
				
				// get existing files datestamp
				$oldtime = filemtime( $path );

				// delete the existing file
				$deleted = unlink( $path );
				
				if( $deleted )
				{
					c2pf_err( 'Existing File Deleted','The old csv file for the one you have uploaded was deleted.' );
				
					// move temp upload to its final path
					move_uploaded_file( $upload['tmp_name'], $path );	
					
					// confirm file was moved
					if ( file_exists( $path ) ) 
					{
						$newtime = filemtime( $path );

						$csv['previousfiledate'] = $oldtime;
						$csv['currenfiledate'] = $newtime;
						$pro['reset'] = time();

						$csv['arraychange'] =  c2pf_arraychange( __LINE__,__FILE__ );

						update_option( 'c2pf_'.$upload['tmp_name'],$csv );
						update_option( 'c2pf_pro',$pro );
						
						c2pf_log( 'Upload Success','CSV file uploaded as an update to existing project',$upload['name'],$set,'Low' );	

						// compare dates and display message
						if( $newtime > $oldtime )
						{
							c2pf_mes( 'Uploaded File Is Newer Than Previous File','New file has been uploaded. Please ensure your Updating settings are complete.' );
						}
						elseif( $newtime < $oldtime )
						{
							c2pf_mes( 'Uploaded File Is Older Than Previous File','It appears that the file you uploaded is an older copy.
							This is confirmed so that you can ensure that you have not uploaded the wrong file and may be updating newer data with old data.' );
						}
						elseif( $newtime == $oldtime )
						{
							c2pf_mes( 'Uploaded File Does Not Appear To Be Different','The plugin checked the date of your existing csv file and the one you
							uploaded. Both modification dates match and so it appears that the csv file you just uploaded may not have new data.' );
						}
					}
					else
					{
						c2pf_log( 'Upload Failed','A CSV file upload attempt failed','Error','Failure' );	
						c2pf_err( 'Upload Failed','The plugin failed to move your new file into the correct directory. Please try again then seek support.' );
					}
				}
			}
		}
	}
}

# Processes CSV File Upload
function c2pf_csvupload( $upload,$set )
{
	//$_POST = stripslashes_deep($_POST);
	
	$upload = $_FILES['file'];
		
	// check for errors
	if ( $upload['error'] != 0 ) 
	{
		c2pf_log( 'Upload Failed','A new file upload attempt failed to start','Error',$set,'Failure' );	
		c2pf_err('Upload Failed To Start','CSV file upload could not be started at all as the file loader returned error, please try again.');
	}
	elseif ( $upload['error'] == 0 ) 
	{	
		// get path data
		$pat = get_option('c2pf_pat');
		
		// if no path data or path not submitted use default
		if( !$pat || !isset( $_POST['c2pf_path'] ) )
		{
			$path = 'default';
			
			// install path array
			c2pf_install_paths();
			
			// now get paths data
			$pat = get_option('c2pf_pat');
		}
		else
		{
			$path = $_POST['c2pf_path'];
		}

		// now get the actual path
		foreach( $pat as $key=>$p )
		{
			if( $path == $key )
			{
				$path = $p['path'];
			}
		}
		
		// confirm path is valid else exit
		$openresult = opendir( $path );
		
		// if failed to open directory display error
		if( !$openresult )
		{
			// use directory name
			// add manual directory creation button to error message
			$createform = '
			<form method="post" name="c2pf_createdirectory" action=""> 
				<input name="c2pf_pathdir" type="hidden" value="'.$path.'" />
				<label>Enter Directory Name:<input name="c2pf_pathname" type="text" value="" size="15" maxlength="15" /></label>
				<input class="button-primary" type="submit" name="c2pf_createdirectory_submit" value="Create Directory" />
			</form>';
			
			c2pf_err('Failed To Open Path/Directory','The path being used for uploading your csv file does not appear to be a valid directory or a directory with
					permissions that will allow the upload. Your CSV file was not uploaded. Here is the directory you are attempting to upload your csv file to and
					a button to create it manually.<br /><br /><strong>Required Path</strong>'.$path.'<br /><br />
					 '.$createform.'');
		}
		else
		{
			// build final file path
			$path = $path.$upload['name'];
			
			// if the final path already exists, delete the existing file then continue
			if ( file_exists( $path ) ) 
			{
				// change file exists switch to true
				$fileexisted = true;
				
				// get existing files datestamp
				$oldtime = filemtime( $path );

				// delete the existing file
				$deleted = unlink( $path );
				
				if( $deleted )
				{
					c2pf_err( 'Existing File Deleted','A matching csv filename was found in the same directory you are uploaded too. It has been deleted as part of the upload process.' );
				}
			}
			else
			{
				$fileexisted = false;
				$deleted = true;// set variable only, has no purpose
			}
									
			// if file could not be delete do not continue and let user know
			if( !$deleted && $fileexisted === true )
			{
				// $deleted or $fileexists do not equal true, both must be true to avoid this
				c2pf_err('File Name Exists Already','You already have a CSV file with the same name in the selected directory. The plugin could not delete it. You will need to delete it manually then try again.');
			}
			elseif( $fileexisted === true && $deleted == true || $fileexisted === false )
			{
				// move temp upload to its final path
				$moveresult = move_uploaded_file( $upload['tmp_name'], $path );
				
				// alert user if file move failed
				if( !$moveresult )
				{
					c2pf_err('File Failed To Upload','There is no clear reason for the failure.
							The plugin confirm no file with the same name exists. Please check
							the directory permissions and ensure you are uploading a correctly
							formatted CSV file. '. $moveresult .'');
				}
				else
				{
					// confirm file has uploaded to the correct directory and path exists
					if ( file_exists( $path ) ) 
					{
						c2pf_mes('CSV Upload Success','You uploaded '.$upload['name'].' and can now use it to create a new project or update an existing one using the file name.');
					}
					else
					{
						c2pf_err('Possible Upload Error','The plugin detected that the upload was a success but on double checking that the uploaded file is 
						now in place, the plugin could not locate your file. Please investigate and report this if the problem persists.');
					}
				}
			}
		}
	}
}

# Deletes WP Options And Returns Result
function c2pf_deleteoptions()
{
	$opts = func_get_args();
	$count = count( $opts );

	if ( $count == 1 ) 
	{
		return (delete_option($opts[0]) ? true : false );
	}
	elseif ( count( $opts ) > 1 )
	{
		foreach ( $opts as $option ) 
		{
			if ( ! delete_option( $option ))
			{
				return false;
			}
		}
		return true;
	}
	return false;
}

# Load CSS And JS For WYSIWYG Editor
function c2pf_wysiwygeditor() 
{
	wp_enqueue_script( 'common' );
	wp_enqueue_script( 'jquery-color' );
	wp_print_scripts('editor');
	if (function_exists('add_thickbox')) add_thickbox();
	wp_print_scripts('media-upload');
	if (function_exists('wp_tiny_mce')) wp_tiny_mce();
	wp_admin_css();
	wp_enqueue_script('utils');
	do_action("admin_print_styles-post-php");
	do_action('admin_print_styles');
}	

# Output: Checks If A Value Is A Valid URL And Returns True Or False
# Input:  The url or any other value if checking to make sure a value is not a url
function c2pf_valid_url($str)
{
	if (!preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i',$str)){return false;}else {return true;}
}

# Activates Wordpress Error Display Which Is Usually Hidden
function c2pf_debugmode()
{
	$deb = get_option('c2pf_deb');
	if( $deb == 'Yes' )
	{
		ini_set('display_errors',1);
		error_reporting(E_ALL);
	}
}

# checks if a projects table already exists or not
function c2pf_istable( $filename )
{
	global $wpdb;
	
	// get table name
	$table_name = c2pf_wptablename( $filename );
	
	// check if table name exists in wordpress database
	if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) 
	{
		return false;
	}
	else
	{
		return true;
	}
}

# Changes The Current Project
function c2pf_changecurrentproject( $filename )
{
	$pro = get_option('c2pf_pro');
	
	// did user submit project that is already the current project
	if( $pro['current'] == $filename )
	{
		c2pf_err('No Changes Made','The project you attempted to activate as the Current Project is already set as the Current Project, no changes were made.');
	}
	else
	{
		$pro['current'] = $filename;

		if( update_option('c2pf_pro',$pro) )
		{
			c2pf_mes('Current Project Changed To '.$filename.'','The "current project" is the one made available for working with right now.');
		}
		else
		{
			c2pf_err('No Changes Made','Wordpress failed to update your project option array. No changes have been made to youplease try again.');
		}
	}
}

// Create the function to output the contents of our Dashboard Widget
function c2pf_dashboard_rsswidget_function() 
{ 
	echo '<script src="http://feeds.feedburner.com/csv2post?format=sigpro" type="text/javascript" ></script><noscript><p>Subscribe to RSS headline updates from: <a href="http://feeds.feedburner.com/csv2post"></a><br/>Powered by FeedBurner</p> </noscript>';
} 

// Create the function use in the action hook
function c2pf_add_dashboard_rsswidgets() 
{
	wp_add_dashboard_widget('c2pf_rssdashboard_widget', 'CSV 2 POST Updates', 'c2pf_dashboard_rsswidget_function');	
} 

// Hook into the 'wp_dashboard_setup' action to register our other functions
add_action('wp_dashboard_setup', 'c2pf_add_dashboard_rsswidgets' );
?>