<?php
# Places Project Tokens Or Shortcodes Into Snippet For Pasting Into WYSIWYG Editor Designs
function c2pf_snippetgenerator( $snippet,$method )
{
	$sni = get_option('c2pf_sni');
	
	if( $method == 't' )
	{
		// column titles currently assumed but later upgrade will allow any column to apply
		$colurl = 'url';
		$colimage = 'image';
		
		// replace url
		$snippet = str_replace ( 'url' , 'x'.$colurl.'x', $sni[$snippet] );
		
		// replace image
		$snippet = str_replace ( 'image' , 'x'.$colimage.'x', $snippet );
	}
	elseif( $method == 's' )
	{
		// column titles currently assumed but later upgrade will allow any column to apply
		$colurl = 'url';
		$colimage = 'image';
		
		// replace url
		$snippet = str_replace ( 'url' , '[c2p '.$colurl.']', $sni[$snippet] );
		
		// replace image
		$snippet = str_replace ( 'image' , '[c2p '.$colimage.']', $snippet );
	}
	
	c2pf_mes( 'Your HTML Snippet','<form><textarea name="snippet" cols="75" rows="5">'.$snippet.'</textarea></form><br />' );
}

# remove directory from plugin data (does not delete folder user must do that ftp etc)
function c2pf_undodirectory( $pathname,$action )
{
	c2pf_mes('Not In Free Edition','The feature you attempted to use is not available in the free edition.');
}

# Saves And Tests Unique Key Submission On Update Stage
function c2pf_processuniquekey( $filename, $key1, $key2, $key3 )
{
	c2pf_mes('Not In Free Edition','The feature you attempted to use is not available in the free edition. Normally
			this is when the plugin checks your Unique Key settings and establishes if the key you created is 
			trully unique. This is an advanced feature and part of updating which requires much support so will
			only be provided in the paid edition.');
}

# Delets CSV File Using Passed Path
function c2pf_deletecsvfile( $pathname,$set )
{
    $do = unlink( $pathname );
    if( $do == "1" )
	{
        c2pf_mes( 'CSV File Deleted','You have deleted '.$pathname.'' );
    } 
	else 
	{ 
		c2pf_err( 'Failed To Delete CSV File','You attempted to delete a csv file but it was not
				possible. Please try again then seek support. Provide the following path
				of your csv file and also confirm that you have double checked that the file
				was not deleted. <br /><br />Path: '.$pathname.'' );
	} 
}

# Saves Update Stage Settings
function c2pf_updatestagesettings( $filename, $updateposts, $autonewfile )
{
	$csv = get_option('c2pf_'.$filename);
	
	$csv['updating']['updateposts'] = $updateposts;
	$csv['updating']['autonewfile'] = $autonewfile;
	$csv['arraychange'] =  c2pf_arraychange( __LINE__,__FILE__ );

	if( update_option( 'c2pf_'.$filename, $csv ) )
	{
		c2pf_mes('Update Settings Saved','Changes have been saved, details for each option saved will be shown below this message.');
		
		if( $csv['updating']['updateposts'] == 'Yes' )
		{
			c2pf_mes('Update Posts Activated','When the plugin has new data stored in your projects table, it will update posts. The update happens only when posts are opened for viewing.');
		}
		else
		{
			c2pf_mes('Update Posts Deactivated','Even when new data is available in your project table, the plugin will not update this projects posts.');
		}
		
		if( $csv['updating']['autonewfile'] == true )
		{
			c2pf_mes('Automatically Process New File Activated','This will cause the plugin to check your
					projects csv file for any changes. If the files modification date is newer than the
					data stored, the plugin will begin updating the project table with the csv files
					data. This will happen based on your speed profile and delay setting.');
		}
		else
		{
			c2pf_mes('Automatically Process New File Deactivated','The plugin will not check for new new csv files on this project or import the new data to apply updates.');
		}				
	}
	else
	{
		c2pf_err('No Changes Saved',ECINOSAVE);
	}
}

# Save Value Swap Submission
function c2pf_valueswapsave( $filename,$type,$old,$new )
{
	c2pf_mes('Not In Free Edition','The feature you attempted to use is not available in the free edition.');
}

# Saves Custom Field Form Changes 
function c2pf_savecustomfields( $filename )
{
	$i = 0;
	$used = 0;
	
	$csv = get_option( 'c2pf_'.$filename );
		
	###############  IMPROVE THIS FUNCTION TO SHOW EXAMPLES OF DATA    ################
	
	// delete current custom fields - removes any no longer entered on form
	if( isset( $csv['customfields'] ) )
	{
		unset( $csv['customfields'] );
	}
	
	while( $i < $_POST['cfcount'] )
	{		
		if( $_POST['cf_'.$i.''] == 'NA' || $_POST['cf_'.$i.''] == '' || $_POST['cf_'.$i.''] == ' ' || $_POST['cf_'.$i.''] == NULL
		|| $_POST['col_'.$i.''] == 'NA' )
		{
			// do nothing even if set to NA we won't add the value to reduce size of arrays
		}
		else
		{
			$csv['customfields'][$_POST['cf_'.$i.'']]['col'] = $_POST['col_'.$i.''];
			$csv['customfields'][$_POST['cf_'.$i.'']]['fun'] = $_POST['fun_'.$i.''];
			++$used;
		}
		
		++$i;
	}

	$csv['arraychange'] =  c2pf_arraychange( __LINE__,__FILE__ );

	if( update_option( 'c2pf_'.$filename,$csv ) )
	{
		c2pf_mes( 'Custom Fields Saved','You have created '.$used.' Custom Fields for adding meta data to your posts' );
	}
	else
	{
		c2pf_err( 'No Custom Fields Changed','Wordpress did not detect any changes made to your Custom Fields' );
	}
}

# Saves Speed Profile Changes
function c2pf_updatespeed( $s )
{
	c2pf_mes('Not In Free Edition','You must use the default speed profile settings. This feature usually requires support from WebTechGlobal and is only in the paid edition.');
}

# Creates Test Post Or Page
function c2pf_designtest( $d,$p )
{
	# REQUIRES POST CREATION FUNCTIONS TO BE COMPLETE
	c2pf_mes('Not Available','This function is to be complete,if you would like it to be made available please send your interest too webmaster@webtechglobal.co.uk');
}

# Saves Project Options
function c2pf_saveprojectoptions( $datemethod,$type,$publish,$comments,$ping,$publisher,$filename,$adopt,$maindesign )
{
	$csv = get_option( 'c2pf_'.$filename );
	
	$csv['datemethod'] = $datemethod;
	$csv['posttype'] = $type;
	$csv['poststatus'] = $publish;
	$csv['postcomments'] = $comments;
	$csv['postpings'] = $ping;
	$csv['postadopt'] = $adopt;
	$csv['postpublisher'] = $publisher;
	$csv['maindesign'] = $maindesign;
	$csv['arraychange'] =  c2pf_arraychange( __LINE__,__FILE__ );

	if( update_option( 'c2pf_'.$filename, $csv ) )
	{
		c2pf_mes( 'Project Options Saved','You may change your options at anytime, even once posts have been created. However changes will only apply to existing posts after update events are initiated.' );
	}
	else
	{
		c2pf_err( 'No Changes Saved','Wordpress could not update the options table at this time. Please try again and seek support if this happens again.' );
	}
}
	
# Saves Category Design Conditions
function c2pf_categorydesignsave( $filename )
{
	$csv = get_option( 'c2pf_' . $filename );
	
	// unset existing category design settings to avoid conflicts
	unset( $csv['conditions']['categorydesigns'] );
	
	$i = 0;
	while( $i < $_POST['catcount'] )
	{
		$csv['conditions']['categorydesigns'][$_POST['category'.$i.'']] = $_POST['c2pf_design'.$i.''];
		++$i;
	}

	$csv['arraychange'] =  c2pf_arraychange( __LINE__,__FILE__ );

	if( update_option( 'c2pf_' . $filename, $csv ) )
	{
		c2pf_mes( 'Category Designs Saved','The plugin will apply different WYSIWYG editor designs depending on a posts main/parent category based on the settings you have saved.' );
	}
	else
	{
		c2pf_err( 'No Changes Saved','It appears that you have not made any changes to the form, no change was made to your options settings.' );
	}
}

# Saves New Or Updates Post Layout Designs From WYSWIYG Editor Page
function c2pf_savedesign($name,$title,$content,$shortcodedesign,$aioseotitle,$aioseodescription)
{	
	$c2p = get_option('c2pf_set');
	$pro = get_option( 'c2pf_pro' );
	$lay = get_option( 'c2pf_lay' );
	$des = get_option('c2pf_des');

	// prepare the standsrd content data 
	$content = str_replace('<br>','<br />',$content);
	$content = str_replace('<hr>','<hr />',$content);

	// if new design we need to set its id using current time
	if( !isset( $des[$name] ) ){$des[$name]['id'] = time();}
	
	$des[$name]['updated'] = time();
	$des[$name]['title'] = $title;
	$des[$name]['content'] = $content;
	
	if( update_option( 'c2pf_des',$des ) )
	{
		c2pf_mes( 'Design Saved','Your design has been saved.' );
	}
	else
	{
		c2pf_err( 'Failed To Save','This is an error that should be reported. Please seek support from WebTechGlobal.' );
	}
}

# save existing folder path as csv file directory
function c2pf_savedirectory( $pathname,$pathdir )
{
	c2pf_mes('Not In Free Edition','The feature you attempted to use is not available in the free edition.');
}
							
# Processes Submission Of New CSV File To Create Project
function c2pf_newproject( $filepath,$set )
{
	// include PEAR CSV
	c2pf_pearcsv_include();
	
	// establish filename of submitted csv file
	$filename = basename( $filepath );   

	// save filename and filepath too project list array - returns false if filename exists already
	if( !c2pf_updateprojectlist( $filename ) )
	{
		c2pf_err('File/Project Name Already In Use','The submitted csv file name is already in use. To prevent
		confusion this is not permitted. Please either delete the existing project or change the 
		name of your csv file.');
	}
	else// continue processing csv file and creating project profile
	{		
		// get project array
		$pro = get_option('c2pf_pro');
		
		//  check if wordpress option value already exists for filename
		if( !$csv = get_option( 'c2pf_'.$filename ) )
		{
			$csv = array();
		}
		
		/* FILE DATESTAMP AND UPDATING TRIGGER
		1. Set a current data and a previous date value
		2. While both do not match it means an update is not complete
		3. Whenever an update is complete, we set previous date to same as current */
		$csv['format']['currenfiledate'] = filemtime( $filepath );
		$csv['format']['previousfiledate'] = filemtime( $filepath );
		
		// use pear to get file configuration
		$conf = File_CSV::discoverFormat( $filepath );
		$fields = File_CSV::read( $filepath, $conf );
		
		// total rows counter (included header row)
		$i = 0;
		
		// start script timer
		$starttime = c2pf_microtimer_start();
		
		// loop through entire csv files records and count total and record titles
		while ( $rows = File_CSV::read( $filepath,$conf ) ) 
		{
			++$i;
		}
		
		// save column titles	
		$count = 0;
		foreach(  $fields as $title )
		{
			$csv['format']['titles'][$count] = $title;
			$count++;
		}
					
		// calculate loop time (use to recommend import speeds etc) - scale of 4
		$csv['operation']['looptime'] = bcsub( time(), $starttime, 4 );
		
		// set csv format
		$csv['format']['rows'] = $i;
		$csv['format']['rowsupdatedtime'] = time();
		$csv['format']['seperator'] = $conf['sep'];
		$csv['format']['quote'] = $conf['quote'];
		$csv['format']['columns'] = $conf['fields'];		
		$csv['sql']['tablename'] =  c2pf_wptablename( $filename );
		$csv['importencoding'] = 'None';
		$csv['arraychange'] =  c2pf_arraychange( __LINE__,__FILE__ );

		// save changes
		update_option( 'c2pf_' . $filename, $csv );
		
		// create standard project values
		$pro['current'] = $filename;// for user interest
		$pro[$filename]['created'] = time();// for user interest
		$pro[$filename]['reset'] = time();// when counters last reset
		$pro[$filename]['filepath'] = $filepath;// full files path
		$pro[$filename]['status'] = 'Paused';// Paused or Active
		$pro[$filename]['speed'] = $_POST['c2pf_speedname'];// switch, indicates not ready or paused etc
		$pro[$filename]['postscreated'] = 0;// includes posts created or deleted during updates
		$pro[$filename]['postsupdated'] = 0;// reset per new update phase
		$pro[$filename]['postsfailed'] = 0;
		$pro[$filename]['adoptsucces'] = 0;
		$pro[$filename]['adoptfailed'] = 0;
		$pro[$filename]['catscreated'] = 0;// number of categories created in project
		$pro[$filename]['tagscreated'] = 0;// number of tags created in project
		$pro[$filename]['rowsinsertsuccess'] = 0;// number of csv files rows inserted (sql succcess)
		$pro[$filename]['rowsinsertfail'] = 0;// number of csv rows that caused sql insert failure
		$pro[$filename]['events'] = 0;// number of events previously actioned for project
				
		// save project array
		update_option('c2pf_pro',$pro);
				
		// build and store the start of the sql insert query
		c2pf_sqlinsert_start( $filename );						
		
		// create project table
		c2pf_createtable( $filename,$set );
		
		// output results - do some checks to ensure we have values we need
		if( $conf && $fields && $csv )
		{
			c2pf_mes('Success - Project Created','The plugin has established the format of your 
			csv file and it is ready to use. Continue through pages 2 to 5 completing each form
			required in your project. Ensure your Design/s are ready, make changes to the project
			Speed Profile you plan to use if required and complete at least parts 1 and 7 on the 
			Project Configuration page before creating posts.');
		}
		else
		{
			c2pf_err('Failed - CSV File Problem','The plugin has tried to establish your csv files
			profile but there has been a problem. Please view the Project Profile page to see
			where the issue is. Visit the WebTechGlobal forum for support if you are unsure.');
		}
	}
}

# create a new folder and save path as csv file directory
function c2pf_createdirectory( $pathname,$pathdir )
{
	c2pf_mes('Not In Free Edition','You can create multiple csv file directories in the free edition.');
}

# Resets Current Update Progress
function c2pf_setnewupdate( $filename )
{
	c2pf_mes('Not In Free Edition','You can use any data or post Update features in the free edition.');
}

# saves exclusion settings on the updating page
function c2pf_columnexclusions( $filename )
{
	c2pf_mes('Not In Free Edition','You can use any data or post Update features in the free edition.');
}

# Saves New Category Group
function c2pf_savegroupcategory( $filename )
{
	$csv = get_option( 'c2pf_'.$filename );
		
	// loop number of columns - used column ID/counter to retrieve the correct POST data and store in array with ID
	$i = 0;
	
	if( isset( $csv['categories'] ) && $csv['categories'] != '' && $csv['categories'] != ' ' )
	{
		foreach( $csv['categories'] as $c )
		{
			$csv['categories'][$i]['cat1'] = $c['cat1'];
			$csv['categories'][$i]['cat2'] = $c['cat2'];
			$csv['categories'][$i]['cat3'] = $c['cat3'];
			
			++$i;
		}
	}
	
	$csv['categories'][$i]['cat1'] = $_POST['c2pf_columnid_c1'];
	$csv['categories'][$i]['cat2'] = $_POST['c2pf_columnid_c2'];
	$csv['categories'][$i]['cat3'] = $_POST['c2pf_columnid_c3'];
	$csv['arraychange'] =  c2pf_arraychange( __LINE__,__FILE__ );
	update_option( 'c2pf_'.$filename,$csv);

	c2pf_mes('Category Group Saved','Your category group has been saved. You can now move to the Conditions stage by pressing the button below.' );		
}

# Saves Conditions Switches
function c2pf_conditionsswitches( $filename )
{
	$csv = get_option( 'c2pf_'.$filename );
	
	if( isset( $_POST['dropposts'] ) ){$csv['conditions']['switches']['dropposts'] = true;}else{$csv['conditions']['switches']['dropposts'] = false;}
	
	if( isset( $_POST['valueswap'] ) ){$csv['conditions']['switches']['valueswap'] = true;}else{$csv['conditions']['switches']['valueswap'] = false;}
	
	if( isset( $_POST['textspin'] ) ){$csv['conditions']['switches']['textspin'] = true;}else{$csv['conditions']['switches']['textspin'] = false;}
	
	if( isset( $_POST['catdesign'] ) ){$csv['conditions']['switches']['catdesign'] = true;}else{$csv['conditions']['switches']['catdesign'] = false;}

	$csv['arraychange'] =  c2pf_arraychange( __LINE__,__FILE__ );

	if( update_option( 'c2pf_'.$filename,$csv ) )
	{
		c2pf_mes( 'Conditions Switches Saved','More condition options will now be available in the Conditions panel.' );
	}
	else
	{
		c2pf_err( 'No Changes Saved','Wordpress made no changes to the Conditions Switches because none appeared to have been changed.' );
	}
}

# Deletes Passed Category Group 
function c2pf_deletecategorygroup( $filename, $groupid )
{
	$csv = get_option( 'c2pf_'.$filename );
	// loop through category groups until we have the one to be deleted
	$i = 0;
	foreach( $csv['categories'] as $set=>$c )
	{		
		// confirm that the submitted group id exists
		if( $set == $groupid )
		{
			unset( $csv['categories'][$groupid] );
			c2pf_mes('Category Group '.$groupid.' Deleted','Please remember to add new category groups if required.');
		}
		++$i;
	}
	
	$csv['arraychange'] =  c2pf_arraychange( __LINE__,__FILE__ );
	$csv['arraychange'] =  c2pf_arraychange( __LINE__,__FILE__ );

	update_option( 'c2pf_'.$filename,$csv );
}

# Saves Single Category
function c2pf_savesinglecategory( $filename, $catid )
{
	$csv = get_option('c2pf_'.$filename);
	$csv['singlecategory'] = $catid;
	if( update_option('c2pf_'.$filename,$csv) )
	{
		if( $catid == 'NA' )
		{
			c2pf_mes('Single Category Disabled','You selected Not Required and the plugin has saved your change. Your project will not assign all new posts to a single category.');
		}
		else
		{
			c2pf_mes('Single Category Saved','Your project will assign all new posts to the selected category.');
		}
	}
	else
	{
		c2pf_mes('No Change Required','You did not appear to make any changes, you must have selected the value already saved.');
	}	
}

# Saves Special Function Page Submission
function c2pf_savespecials( $filename )
{
	global $wpdb;
	
	$csv = get_option( 'c2pf_'. $filename );
	$set = get_option('c2pf_set');
	
	// get a single record for using as examples		
	$record = $wpdb->get_results( 'SELECT * FROM '. c2pf_wptablename( $filename ) .' WHERE c2ppostid IS NULL OR c2ppostid = 0 LIMIT 1' );
	
	if( !$record )
	{
		c2pf_err('Failed To Retrieve Test Data','The plugin needs a single record to be imported to the project database table. The records data is tested with various parts of your configuration including Special Functions. Please go to First Data Import stage and initiate a data import.');
	}
	else
	{
		// loop number of columns - used column ID/counter to retrieve the correct POST data and store in array with ID
		$i = 0;
		
		// put all post values into data array
		$csv['specials']['col']['madetags_col'] = $_POST['c2pf_spec_madetags'];
		$csv['specials']['col']['thumbnail_col'] = $_POST['c2pf_spec_thumbnail'];
		$csv['specials']['col']['cloaking1_col'] = $_POST['c2pf_spec_cloaking1'];
		$csv['specials']['col']['permalink_col'] = $_POST['c2pf_spec_permalink'];
		$csv['specials']['col']['dates_col'] = $_POST['c2pf_spec_dates'];
		$csv['specials']['col']['tags_col'] = $_POST['c2pf_spec_tags'];
		$csv['specials']['col']['excerpt_col'] = $_POST['c2pf_spec_excerpt'];
		$csv['specials']['col']['catsplitter_col'] = $_POST['c2pf_spec_catsplitter'];
		// preset the switch too Off
		$csv['specials']['state']['madetags_col'] = 'Off';
		$csv['specials']['state']['thumbnail_col'] = 'Off';
		$csv['specials']['state']['cloaking1_col'] = 'Off';
		$csv['specials']['state']['permalink_col'] = 'Off';
		$csv['specials']['state']['dates_col'] = 'Off';
		$csv['specials']['state']['tags_col'] = 'Off';
		$csv['specials']['state']['excerpt_col'] = 'Off';
		$csv['specials']['state']['catsplitter_col'] = 'Off';

		foreach( $record as $data )
		{			
			// Pre-Made Tags 
			if( $csv['specials']['col']['madetags_col'] != 'NA' )
			{ 
				$csv['specials']['state']['madetags_col'] = 'On'; 
				$col = c2pf_cleansqlcolumnname($csv['specials']['col']['madetags_col']);
				eval('$value = $data->$col;');
				c2pf_mes('Pre-Made Tags Example',$value);
			}
			
			// Thumbnail
			if( $csv['specials']['col']['thumbnail_col'] != 'NA' )
			{ 
				$csv['specials']['state']['thumbnail_col'] = 'On'; 
				$col = c2pf_cleansqlcolumnname($csv['specials']['col']['thumbnail_col']);
				eval('$value = $data->$col;');
				c2pf_mes('Thumbnail Example','URL: '.$value.'<br /><br /><img src="'.$value.'" width="200" height="200" />');
			}
			
			// cloaking
			if( $csv['specials']['col']['cloaking1_col'] != 'NA' )
			{ 
				$csv['specials']['state']['cloaking1_col'] = 'On';
				$col = c2pf_cleansqlcolumnname($csv['specials']['col']['cloaking1_col']);
				eval('$value = $data->$col;');
				c2pf_mes('URL Cloaking Example','URL Data: '.$value.'<br /><br />Example Cloak Only: '. get_bloginfo( 'url' ) . '?viewitem=12345&section=2');
			}
			
			// permalink 1
			if( $csv['specials']['col']['permalink_col'] != 'NA' )
			{ 
				$csv['specials']['state']['permalink_col'] = 'On'; 
				$col = c2pf_cleansqlcolumnname($csv['specials']['col']['permalink_col']);
				eval('$value = $data->$col;');
				c2pf_mes('Parmalink Example','PermalinkData: '.$value.'<br /><br />Example URL: '. get_bloginfo( 'url' ) . $value);
			}

			// dates
			if( $csv['specials']['col']['dates_col'] != 'NA' )
			{ 
				$csv['specials']['state']['dates_col'] = 'On'; 
				$col = c2pf_cleansqlcolumnname($csv['specials']['col']['dates_col']);
				eval('$value = $data->$col;');
				
				// if string to time could not be done, output some help information
				if ( ( $timestamp = strtotime( $value ) ) === false ) 
				{
					c2pf_err( 'Date Format Problem','It appears the date value tested could not be converted for using in Wordpress. Try replacing any
							slashes used in your dates with hyphens instead. The specific problem is that when the plugin attempts to use the strtotime 
							php function, the function returns false. Here are sources which explain more about this procedure.<br /><br />							
							<a href="http://www.webtechglobal.co.uk/blog/help/eci-tutorial-date-formatting" target="_blank">Go to CSV 2 POST Date Format help page and leave a comment for quick support</a>' );;
				} 
				else 
				{
					c2pf_mes('Date Example & Formatting Test','
					Your Data Value: '.$value.'<br /><br />
					Date Wordpress Formated: '.date("Y-m-d H:i:s", $timestamp).'<br /><br />
					Extended Test: '.date('l dS \o\f F Y h:i:s A', $timestamp).'<br /><br />
					PHP strtotime: '.$timestamp.'<br /><br />');
				}
			}
			
			// tags
			if( $csv['specials']['col']['tags_col'] != 'NA' )
			{ 
				$csv['specials']['state']['tags_col'] = 'On'; 
				$col = c2pf_cleansqlcolumnname($csv['specials']['col']['tags_col']);
				eval('$value = $data->$col;');
				$value = c2pf_createtags( $value, $set['tagschars'], $set['tagsnumeric'], $set['tagsexclude'] );
				c2pf_mes('Generated Tags Example',$value.' (based on any changes you have made in the settings page');
			}
			
			// excerpt
			if( $csv['specials']['col']['excerpt_col'] != 'NA' )
			{ 
				$csv['specials']['state']['excerpt_col'] = 'On'; 
				$col = c2pf_cleansqlcolumnname($csv['specials']['col']['excerpt_col']);
				eval('$value = $data->$col;');
				$value = c2pf_createexcerpt( $value,150 );
				c2pf_mes('Generated Excerpt Example',$value);
			}
			
			// category splitter
			if( $csv['specials']['col']['catsplitter_col'] != 'NA' )
			{ 
				$csv['specials']['state']['catsplitter_col'] = 'On'; 
				$col = c2pf_cleansqlcolumnname($csv['specials']['col']['catsplitter_col']);
				eval('$value = $data->$col;');
					
				// remove spaces from string
				$value = str_replace(' ','',$value);
						
				// explode resulting string
				$value = explode('/',$value,3);
						
				$cats = '';
				$count = 0;
				foreach( $value as $cat )
				{
					if( $count != 0 )
					{
						$cats .= ',';
					}
							
					$count++;
							
					$cats .= $cat;
				}
						
				c2pf_mes('Split Colums Example',$cats);
			}			
			
			++$i;
		}

		$csv['arraychange'] =  c2pf_arraychange( __LINE__,__FILE__ );
		$result = update_option( 'c2pf_'.$filename,$csv );
		
		if( $result )
		{
			c2pf_mes( 'Special Functions Saved','Your changes for Special Functions 
			setup has been saved. If you used any of the functions available you
			should see samples for your selections below.' );	
		}
		else
		{
			c2pf_err('No Changes Made','Your configuration for the Special Functions
					form did not save. This is usually because no changes were made to the
					form.');
		}
	}
}

# Deletes Project
function c2pf_deleteproject( $filename )
{
	c2pf_mes('No Permission','Cannot delete project. Please manually delete your csv file and use the Settings page to reset the plugins data.');
}

# Saves Speed Profile For Data Import And Offers Further Import Actions
function c2pf_dataimport_speedprofile( $speed,$filename )
{
	c2pf_mes('Not In Free Edition','You cannot make changes to speed profiles in the free edition. It is recommended that you use the default settings until you are paying for support.');
}

# Delete Speed Profile
function c2pf_deletespeed( $speedname )
{
	c2pf_mes('Not In Free Edition','You cannot make changes to speed profiles in the free edition. It is recommended that you use the default settings until you are paying for support.');
}

function c2pf_updateprojectlist( $filename )
{
	$pro = get_option('c2pf_pro');
	
	$saved = true;
	
	$counter = 0;
	
	// loop through projects 
	if( $pro )
	{
		foreach( $pro as $key=>$file )
		{ 
			// if match to submitted csv file found return false
			if( $key == $filename )
			{
				$saved = false;
			}
			++$counter; 
		}	
		
		if( $saved == true )
		{
			update_option('c2pf_pro',$pro);
		}
	}
	else
	{
		$saved = false;
	}
	
	// returning false indicates no save made because the filename exists already
	return $saved;
}
?>