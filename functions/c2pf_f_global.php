<?php
# Count And Saves Current CSV Files Rows For Giving Project And Path
function c2pf_countcsvrows( $filename,$csv ){}

# Displays A Message Only If Visitor Is Admin
function c2pf_adminmes( $title,$message,$type )
{
	if( is_admin() && $type == 'mes' )
	{
		c2pf_mes( $title,$message );
	}
	elseif( is_admin() && $type == 'err' )
	{
		c2pf_mes( $title,$message );
	}
}

# Replaces URL In Post Content With Cloak - Real URL Stored In Custom Field
function c2pf_applyurlcloaking( $csv,$recordarray,$my_post )
{
	if( isset( $csv['specials']['col']['cloaking1_col'] ) && isset( $csv['specials']['state']['cloaking1_col'] ) && $csv['specials']['state']['cloaking1_col'] == 'On' )
	{
		// build cloak urk
		$cloak = get_bloginfo( 'url' ) . '?viewx=' . $my_post['ID'] . '&caty=1';
		
		// get real url
		$url = $recordarray[ $csv['specials']['col']['cloaking1_col'] ];

		// replace real url with cloak 
		$my_post['post_content'] = str_replace( $url, $cloak, $my_post['post_content'] );// replace data url with cloaking url
		
		// add custom field for holding real url
		update_post_meta( $my_post['ID'], 'c2pf_cloakurl1',$url, true );
		
		// add custom field for storing cloak clicks
		update_post_meta( $my_post['ID'], 'c2pf_clicks_url1', '0', true );			
	}
	
	return $my_post;
}

// creates custom fields - used in update procedures and post creation
function c2pf_addcustomfields( $id,$recordarray,$csv,$filename,$set )
{		
	// loop through custom fields - get
	if( isset( $csv['customfields'] ) )
	{
		// loop through custom fields
		foreach( $csv['customfields'] as $key => $cf )
		{	
			// avoid attempting to use invalid values in column value
			if( $cf['col'] != 'NA' && $cf['col'] != '' && $cf['col'] != ' ' )
			{	
				// get record value into $value variable
				$value = $recordarray[ $cf['col'] ];
				
				// check if custom field values requires a data function
				if( $cf['fun'] != 'NA' && $cf['fun'] != '' && $cf['fun'] != ' ' )
				{
					// apply the required functon
					if( $cf['fun'] == 'keywordgenerator' )
					{
						$value = c2pf_createkeywords( $value,10,$set['tagsexclude'] );
					}
				}
				
				if( !update_post_meta($id, $key, $value, true) )
				{
					c2pf_log( 'Update Post Meta','Failed for post ID:'.$id.' Key:'.$key.' Value:'.$value.'',$filename,$set,'Critical' );	
				}
			}
		}
	}
}

# Calculates Current Progress For Update - Both Insert And Update Counters Reset For Update
function c2pf_progress( $filename )
{
	$pro = get_option( 'c2pf_pro' );
	$progress = $pro[$filename]['rowsupdatesuccess'] + $pro[$filename]['rowsupdatefail'] + $pro[$filename]['rowsinsertsuccess'] + $pro[$filename]['rowsinsertfail'];
	return $progress;
}
	
# Checks CSV File Time Stamp, Updates Prof,ile Then Returns An Array With The Current And Previous Dates
function c2pf_filetime( $filename,$pro,$csv,$set )
{
	// create array for return
	$filedateresults = array();
		
	// is the project name/csv file name a cleaned name (old one will be stored in $csv profile)
	if( isset( $csv['precleanfilepath'] ) )
	{
		// check for a file existing with the old name
		if ( file_exists( $csv['precleanfilepath'] ) ) 
		{
			$newpathexists = true;
			$newpathdeleted = false;
			
			// delete existing project file
			if( !unlink( $pro[$filename]['filepath'] ) )
			{
				c2pf_log( 'File Delete Failure','Project appears to have a new file, old one could not be deleted',$filename,$set,'Critical' );
			}
			else
			{
				// now do the rename, use the pre clean file path in $csv and the permanent path from $pro
				if( !rename( $csv['precleanfilepath'], $pro[$filename]['filepath'] ) )
				{
					c2pf_log( 'File Rename Failure','Project has a new file with the old filename, it must be renamed but it could not be',$filename,$set,'Critical' );
				}		
			}
		}		
	}

	// get project file path
	$stamp['current'] = filemtime( $pro[$filename]['filepath'] );
	$stamp['changed'] = 'No';
	
	// if the files date being checked is not equal to the one saved then update currentfiledate,project progress counters and csv file profile
	if( isset( $csv['format']['currenfiledate'] ) && $stamp['current'] != $csv['format']['currenfiledate'] )
	{
		// add old date to array before it is changed
		$stamp['previous'] = $csv['format']['currenfiledate'];
		
		// currentfiledate as stored in array (not new one) now becomes previousfiledate
		$csv['format']['previousfiledate'] = $csv['format']['currenfiledate'];
		
		// new file date now becomes currentfiledate - this difference between two triggers updating events
		$csv['format']['currenfiledate'] = $stamp['current'];
		$csv['arraychange'] =  c2pf_arraychange( __LINE__,__FILE__ );
		update_option( 'c2pf_'.$filename, $csv );
		
		// must also count number of rows in csv file
		c2pf_countcsvrows( $filename,$csv );
		
		// we also need to reset import/update progress to allow events to continue
		c2pf_resetprogress( $filename,$pro,'c2pf_filetime detected new file',$set );
		
		// change the changed value in array
		$stamp['changed'] = 'Yes';
	}	
	
	return $stamp;
}

# Resets Progress Counters For Project In Order To Make Auto Import or Update Continue
function c2pf_resetprogress( $filename, $pro, $reason, $set )
{
	$pro[$filename]['rowsupdatesuccess'] = 0;
	$pro[$filename]['rowsupdatefail'] = 0;
	$pro[$filename]['rowsinsertsuccess'] = 0;
	$pro[$filename]['rowsinsertfail'] = 0;
	$pro['reset'] = time();
	if( update_option( 'c2pf_pro', $pro ) )
	{
		c2pf_log( 'Schedule','Progress reset complete. Reason: '.$reason.'','Operation',$set,'Low' );
	}
	else
	{
		c2pf_err( 'Schedule','Failed to reset progress for reason: '.$reason.'','Operation',$set,'Critical' );
	}
	
	return $pro;
}

# Adds Final Publish Date To $my_post Object
function c2pf_postdate( $csv,$my_post,$recordarray,$set,$filename )
{					
	if( isset( $csv['specials']['col']['dates_col'] ) && isset( $csv['specials']['state']['dates_col'] ) 
	&& $csv['specials']['state']['dates_col'] == 'On' 
	&& isset( $csv['datemethod'] ) && $csv['datemethod'] == 'data' )
	{		
		// if string to time could not be done, output some help information
		if ( ( $timestamp = strtotime( $recordarray[ $csv['specials']['col']['dates_col'] ] ) ) === false ) 
		{
			###############     LOG FAILURE AND ADMIN OUTPUT     ####################
		} 
		else 
		{
			$my_post['post_date'] =  date("Y-m-d H:i:s", $timestamp);
			$my_post['post_date_gmt'] = gmdate("Y-m-d H:i:s", $timestamp );
		}
	}
	elseif( isset( $csv['datemethod'] ) && $csv['datemethod'] == 'random' )
	{	
		$time = rand(
		mktime( 23, 59, 59, $set['rd_monthstart'], $set['rd_daystart'], $set['rd_yearstart'] ),
		mktime( 23, 59, 59, $set['rd_monthend'], $set['rd_dayend'], $set['rd_yearend'] ) );// end of rand 
		$my_post['post_date'] = date("Y-m-d H:i:s", $time);
		$my_post['post_date_gmt'] = gmdate("Y-m-d H:i:s", $time);
	}		
	elseif( isset( $csv['datemethod'] ) && $csv['datemethod'] == 'increment' )
	{
		if( isset( $pro['lastpublishdate'] ) )
		{
			$lastdate = strtotime( $pro[$filename]['lastpublishdate'] );
			$increment = rand( $set['incrementstart'], $set['incrementend'] );
			$time = $lastdate + $increment;
			$my_post['post_date'] = date("Y-m-d H:i:s", $time);	
			$my_post['post_date_gmt'] = gmdate("Y-m-d H:i:s", $time);
		}
		if( !isset( $pro['lastpublishdate'] ) )
		{
			$time = mktime( 23, 59, 59, $set['incrementmonthstart'], $set['incrementdaystart'], $set['incrementyearstart'] );
			$my_post['post_date'] = date("Y-m-d H:i:s", $time);
			$my_post['post_date_gmt'] = gmdate("Y-m-d H:i:s", $time);
		}
	}
	elseif( isset( $csv['datemethod'] ) && $csv['datemethod'] == 'default' )
	{
		$my_post['post_date'] = date( "Y-m-d H:i:s",time() );
		$my_post['post_date_gmt'] = gmdate( "Y-m-d H:i:s",time() );
	}					
					
	return $my_post;
}

# Ensures Pre-Made Tags Are Valid 
function c2pf_createtags_premade($str) 
{
	// split passed value - expecting a comma delimited string of values including phrases
	$splitstr = @explode(",", $str);
	$new_splitstr = array();
	foreach ($splitstr as $spstr) 
	{
		// ensure individual value is not already in tags array
		if (strlen($spstr) > 2 && !(in_array(strtolower($spstr), $new_splitstr))){$new_splitstr[] = strtolower($spstr);}
	}
	return @implode(", ", $new_splitstr);
}

# Adds Values Too Giving $my_post Object Based On Special Functions Settings
function c2pf_populatemypost_specialfunctions( $my_post,$recordarray,$csv,$set )
{
	// wordpress post excerpt value
	if( isset( $csv['specials']['col']['excerpt_col'] ) && isset( $csv['specials']['state']['excerpt_col'] ) && $csv['specials']['state']['excerpt_col'] == 'On' )
	{					
		$my_post['post_excerpt'] = c2pf_createexcerpt( $recordarray[ $csv['specials']['col']['excerpt_col'] ], $set['excerptlimit'] ); 
	}		
	
	// tags - premade tags override generated tags
	if( isset( $csv['specials']['col']['madetags_col'] ) && isset( $csv['specials']['state']['madetags_col'] ) && $csv['specials']['state']['madetags_col'] == 'On'   )
	{ 	
		$my_post['tags_input'] = c2pf_createtags_premade( $recordarray[ $csv['specials']['col']['madetags_col'] ] );
	}		
	elseif( isset( $csv['specials']['col']['tags_col'] ) && isset( $csv['specials']['state']['tags_col'] ) && $csv['specials']['state']['tags_col'] == 'On' )
	{
		$my_post['tags_input'] = c2pf_createtags( $recordarray[ $csv['specials']['col']['tags_col'] ],$set['tagschars'], $set['tagsnumeric'], $set['tagsexclude'] );
	}

	// post name/permalink
	if( isset( $csv['specials']['col']['permalink_col'] ) && isset( $csv['specials']['state']['permalink_col'] ) && $csv['specials']['state']['permalink_col'] == 'On' )
	{
		$my_post['post_name'] = $recordarray[ $csv['specials']['col']['permalink_col'] ];
	}
	
	return $my_post;
}

# Extracts And Returns Comma Seperated Keywords From String Of Text
function c2pf_createtags($str, $length, $tagsnumeric, $exclude) 
{
	// replace full stops and commas with a space
	$str = str_replace(array(",",".")," ", $str );

	// strip html
	$str = c2pf_striphtmltags( $str );

	// shorten string
	$str = c2pf_truncatestring( $str, $length);

	// explode words into array - we'll loop through these
	$splitstr = explode(" ",$str);

	// start new array
	$new_splitstr = array();

	// explode exclusions into array
	$exclude = explode(",", $exclude);

	// loop through each word
	foreach ( $splitstr as $spstr ) 
	{
		if( $tagsnumeric == 'Exclude' )
		{	// numeric only values will be removed
			if (strlen($spstr) > 2 
			&& !(in_array(strtolower($spstr), $new_splitstr)) 
			&& !(in_array(strtolower($spstr), $exclude ) ) 
			&& !is_numeric($spstr)) 
			{
				#####  IMPROVE TO ALLOW FORMAT SUCH AS CAPTIAL FIRST LETTER,ALL LOWER CASE ETC #####
				//$new_splitstr[] = strtolower($spstr);
				$new_splitstr[] = $spstr;
			}
		}
		elseif($tagsnumeric == 'Include')
		{	
			// numeric only values will be included
			if ( strlen( $spstr ) > 2 
			&& !( in_array( strtolower( $spstr ), $new_splitstr ) ) 
			&& !( in_array( strtolower( $spstr ), $exclude ) ) ) 
			{
				#####  IMPROVE TO ALLOW FORMAT SUCH AS CAPTIAL FIRST LETTER,ALL LOWER CASE ETC #####
				//$new_splitstr[] = strtolower($spstr);
				$new_splitstr[] = $spstr;
			}
		}
	}

	return @implode(",", $new_splitstr);
}


# Creates Comma Seperated String Of Keywords Based On Settings Including Exclusions
function c2pf_createkeywords( $str, $words, $exclude ) 
{
	// replace fukll stops and commas with a space so they are not included in keywords
	$str = str_replace( array(",",".")," ", $str );

	// strip html
	$str = c2pf_striphtmltags( $str );

	// explode words using explode which puts each seperate word in array
	$splitstr = @explode(" ", $str);
	
	// start new array
	$new_splitstr = array();
	
	$exclude = @explode(",", $exclude);
	
	// loop through each word
	foreach ($splitstr as $spstr) 
	{	// ensure word is more than 2 characters, is not already in string and is not in exclude array
		if (strlen($spstr) > 2 
		&& !(in_array(strtolower($spstr), $new_splitstr)) 
		&& !(in_array(strtolower($spstr), $exclude))) 
		{
			//$new_splitstr[] = strtolower($spstr);
			$new_splitstr[] = strtolower($spstr);
		}
	}
	
	// implode array of words into a string then return
	return @implode(",", $new_splitstr);
}

# First/Main Function For Creating Posts
function c2pf_createposts( $csv,$pro,$spe,$set,$des,$posts,$output,$filename )
{	
	global $wpdb;
	
	// increase events counter for campaign
	++$pro[$filename]['events'];
	
	// execute sql SELECT query to get records
	$records = $wpdb->get_results( 'SELECT * FROM '. $csv['sql']['tablename'] .' WHERE c2ppostid IS NULL OR c2ppostid = 0 LIMIT '. $posts .'' );
	
	if( !$records )
	{
		c2pf_log( 'Create Posts','No posts created as no records were available',$filename,$set,'High' );	
		if( $output ){c2pf_mes('No Records Available','Either your project table does not have any imported data or all records have already been used.');}
	}
	else
	{
		c2pf_log( 'Create Posts','Post creation procedure started',$filename,$set,'Low' );	

		// prepare progress variables for output only - $pro array is updated as events happen
		$progress = array();
		$progress['createsuccess'] = 0;// number of posts created and completed by update
		$progress['createfailed'] = 0;// number of posts that did not complete at any stage

		// begin looping through all records
		foreach( $records as $record )
		{	
			// create switch to indicate failed post creation attempt
			$failed = false;
			
			// put the records data into an array with the key being column names
			$recordarray = c2pf_recordarray( $csv,$record );
				
			// start column counter
			$col = 0;
			
			// get category id array
			$cats = c2pf_categorise( $csv,$pro,$spe,$set,$filename,$record,$output,$recordarray );
						
			// get design templates in an array
			$designarray = c2pf_postcreation_getlayouts( $cats[0],$des,$csv );

			// create post and return the post object
			$my_post = c2pf_createbasepost( date("Y-m-d h:i:s"),gmdate("Y-m-d h:i:s"),$designarray,'pending' );
				
			// only continue if $my_post is not false
			if( !$my_post )
			{
				c2pf_log( 'Create Posts','wordpress returned fail when creating the base posts',$filename,$set,'Failure' );	

				// creating base post failed			
				++$progress['createfailed'];
				++$pro[$filename]['postsfailed'];
				update_option( 'c2pf_projects',$pro );
			}
			elseif( $my_post )
			{
				c2pf_log( 'Created Post','A base post with id '.$my_post['ID'].' was created',$filename,$set,'Low' );	

				// add categories to my_post object
				$my_post['post_category'] = $cats;

				// process design code and insert data values over tokens - return design object again
				$designarray = c2pf_populatedesign( $designarray, $recordarray, $csv );

				// build the rest of $my_post
				$my_post['post_type'] = $csv['posttype'];
				$my_post['comment_status'] = $csv['postcomments'];
				$my_post['to_ping'] = $csv['postpings'];
				$my_post['post_author'] = $csv['postpublisher'];
				$my_post['post_title'] = $designarray['title'];
				$my_post['post_content'] = $designarray['content'];

				// populate $my_post object with any further data required by special functions
				$my_post = c2pf_populatemypost_specialfunctions( $my_post,$recordarray,$csv,$set );
				
				// put unique key columns into an array - used to adopt existing posts
				$uniquearray = c2pf_uniquekey( $csv,$recordarray );

				// add required custom fields
				c2pf_addcustomfields( $my_post['ID'],$recordarray,$csv,$filename,$set );
				
				// apply url cloaking
				$my_post = c2pf_applyurlcloaking( $csv,$recordarray,$my_post );

				// establish publish date and add to $my_post object
				$my_post = c2pf_postdate( $csv,$my_post,$recordarray,$set,$filename );
				
				// if user has not set own post name - create it now
				if( !isset( $my_post['post_name'] ) )
				{
					$my_post['post_name'] = sanitize_title( $my_post['post_title'] );
				}	
				
				// apply publish date to last publish date value for tracking incremental publishing
				$pro[$filename]['lastpublishdate'] = $my_post['post_date'];		
	
				// using final publish date - make final decision on post status (users selected or future for schedule posts)
				$my_post = c2pf_poststatus( $csv,$my_post,$pro );
			
				// duplication check
				$duplicatearray = c2pf_duplicateposts( $csv,$my_post,$filename,$set );

				// add csv2post custom fields
				c2pf_postbuildmeta( $my_post['ID'], $filename, $record->c2pid, $csv['sql']['tablename'] );
	
				// update this record with its matching post id in the project database table
				$wpdb->query('UPDATE '. $csv['sql']['tablename'] .' SET c2ppostid = '.$my_post['ID'].' WHERE c2pid = '.$record->c2pid.'');
                
				// update post - ID returned on success
				$my_post['ID'] = wp_update_post( $my_post ); 
	
				// update project progress if success
				if( !$failed && $my_post['ID'] )
				{
					++$pro[$filename]['postscreated'];
					++$progress['createsuccess'];
				}
				elseif( $failed && $my_post['ID'] )
				{
					c2pf_log( 'Create Post Fail','Failed switch true',$filename,$set,'High' );	
					++$pro[$filename]['postsfailed'];
					++$progress['createfailed'];
				}
				elseif( $failed && !$my_post['ID'] )
				{
					c2pf_log( 'Create Post Fail','Failed switch true and no post id returned by update',$filename,$set,'High' );	
					++$pro[$filename]['postsfailed'];
					++$progress['createfailed'];
				}				
				elseif( !$failed && !$my_post['ID'] )
				{
					c2pf_log( 'Create Post Fail','No post id returned by update',$filename,$set,'High' );	
					++$pro[$filename]['postsfailed'];
					++$progress['createfailed'];
				}
				
				// update progress array
				update_option( 'c2pf_pro',$pro );
			}
			
			// put the post id into variable for returning
			$postid = $my_post['ID'];
			
			// if a single post created do not unset the $my_post object else unset
			if( $posts > 1 )
			{
				unset($my_post);
			}
		}// end of for each record
		
		c2pf_log( 'Create Posts','Posts Created:'.$progress['createsuccess'].' Create Failed:'.$progress['createfailed'].' Adopted:'.$progress['adoptsucces'].' Adopt Failed:'.$progress['adoptfailed'].'',$filename,$set,'High' );	
		
		// if a single post is created, add some of the posts details to the output
		if( $posts == 1 )
		{
			$singlepost
			= '
			<h4>Post Details</h4>
			Title: '.$my_post['post_title'].'<br />
			ID: '.$my_post['ID'].'<br />
			Publish Date: '.$my_post['post_date'].'<br />
			Tags: '.$my_post['tags_input'].'<br />
			
			<h4>Post Content Dump</h4>
			Content: '.$my_post['post_content'].'<br />
			';
		}
		
		// complete output if requested
		if( $output )
		{
			$resultmes = '<h4>Post Creation Event Results</h4>';
			
			if( isset( $progress['createsuccess'] ) && $progress['createsuccess'] != 0 )
			{
				$resultmes .= 'Post Create Success: '.$progress['createsuccess'].'<br />';
			}
						
			if( isset( $progress['createfailed'] ) && $progress['createfailed'] != 0 )
			{
				$resultmes .= 'Post Create Failed: '.$progress['createfailed'].'<br />';
			}
						
			$resultmes .= '<h4>Project Progress (all events)</h4>
			Posts/Pages Created: '.$pro[$filename]['postscreated'].'<br />
			Categories Created: '.$pro[$filename]['catscreated'].'<br />
			Tags Created: '.$pro[$filename]['tagscreated'].'<br />
			Project Records: '.$pro[$filename]['rowsinsertsuccess'].'<br /><br />';
			
			c2pf_mes( 'Event Complete - Event Results And Project Progress Below',$resultmes . $singlepost );

		}
		
		// return the last POST ID - for use when plugin requests a single post can confirm its ID to the user
		return $postid;
	}
}

# Cleans And Returns Filenames
function c2pf_cleanfilename( $filename )
{
	$filename = str_replace ( '-' , '' ,  $filename );
	$filename = str_replace ( '_' , '' ,  $filename );
	$filename = str_replace ( ' ' , '' ,  $filename );
	$filename = str_replace ( ')' , '' ,  $filename );
	$filename = str_replace ( '(' , '' ,  $filename );
	return $filename;
}

# Replaces Values In Post Content or Post
function c2pf_conditionreplace( $my_post, $csv )
{
	return $my_post;
}				

# Returns Required Design Based On Conditional Criteria
function c2pf_postcreation_getlayouts( $parentcat,$des,$csv )
{
	return $des['Default'];
}

// Returns Details About Where And When An Array Is Being Changed
function c2pf_arraychange( $line, $file )
{
	$change = array();
	$change['date'] = date("Y-m-d H:i:s");
	$change['time'] = time();
	$change['line'] = $line;
	$change['file'] = $file;
	return $change;
}

// intercept all posts and review content, do any editing to data and current values
function c2pf_updatethepost( $posts )
{	
	return $posts;
}

# Checks If Giving Speed Profile Name Is In Use By Project And Returns False Or Project Name
function c2pf_speedprofile_inuse( $speedname )
{
	$pro = get_option( 'c2pf_pro' );
	if( !$pro )
	{
		c2pf_notifications( 'Admin','Project array could not be obtained for function c2pf_speedprofile_inuse','NA',10 );		
		return false;
	}
	else
	{
		foreach( $pro as $key => $p )
		{
			// find a project that is active and uses the giving speedprofile
			if( $p['speed'] == $speedname && $p['status'] == 'Active' )
			{
				return $key;
			}
		}
		// return false if no suitable project found
		return false;
	}
}

# Determines If Log Is Activated And Required Name
function c2pf_log( $action,$text,$type,$set,$priority )// low,high,failure
{
	if( isset( $set['log'] ) && $set['log'] == 'Yes' )
	{		
		if ( !file_exists( C2PPATH.'log.csv' ) ) 
		{
			$header = array();
			$header = array( 'DATE','ACTION','DESCRIPTION','PROJECT','PRIORITY' );
			$fp = fopen( C2PPATH.'log.csv', 'w');
			
			if( !$fp )
			{				
				c2pf_notifications( 'Admin','Post creation event attempted but no records available to create posts with','NA',10 );
			}
			else
			{
				fputcsv($fp, $header );
			}
		} 
		else
		{
			// check file size - delete if over 300kb as stated on Log page
			if( filesize( C2PPATH.'log.csv' ) > 307200 )
			{
				// delete file
				unlink( C2PPATH.'log.csv' );
				
				// call this function so that log is created again with notification of delete
				c2pf_log( 'Log Reset','Your log file was reset','Operation',$set,'Low' );
			}
		}
	}
		   
	$write = array();
	$write = array( date("Y-m-d H:i:s",time() ),$action, $text, $type, $priority );
	$fp = fopen( C2PPATH.'log.csv', 'a');
	fputcsv($fp, $write);
	fclose($fp);	
}

# Gets Multiple Records, Category Columns Only And Passes Each Record Too c2pf_categorise
function c2pf_categoriseearly( $csv,$pro,$spe,$set,$filename,$output )
{
	#########  ALLOW DEACTIVATION OF CATEGORY CHECKING ONCE THIS HAS BEEN USED   ####################
	
	$col = 0;
	
	// start select columns
	$select = 'SELECT ';
	
	// get all records by choosing category columns that are unique among themselves
	if( isset( $csv['singlecategory'] ) && !empty( $csv['singlecategory'] ) && $csv['singlecategory'] != 'NA' )
	{
		// if single category is set then we only need to retrieve the data for one column
		$select .= $csv['singlecategory'];
		$sqlcolumn1 = c2pf_cleansqlcolumnname( $csv['singlecategory'] );
	}
	else
	{
		global $wpdb;
		$catset = 0;
		if( isset( $csv['categories'][$catset]['cat1'] ) )
		{
			$select .= c2pf_cleansqlcolumnname( $csv['categories'][$catset]['cat1'] );
			$column1 = $csv['categories'][$catset]['cat1'];
			$sqlcolumn1 = c2pf_cleansqlcolumnname( $csv['categories'][$catset]['cat1'] );
		}
	}
	
	##############   CREATE SETTING FOR THIS LIMIT    ##########################
	$limit = 999999;
	$records = $wpdb->get_results( $select . ' FROM '. $csv['sql']['tablename'] .' LIMIT '. $limit .'' );
	
	if( !$records )
	{
		if( $output )
		{
			c2pf_err( 'No Records Available','No categories were created because your project database table has no records.' );
		}
		else
		{
			##############  ADD LOG ENTRY AND NOTIFICATION
		}
	}
	else
	{
		if( $output )
		{
			c2pf_mes( 'Category Creation Running','The size of your data will determine how long this takes.' );
		}
		
		// loop through all records retrieved - for each loop pass record to c2pf_categorise to applye category columns
		foreach( $records as $record )
		{			
			// put record into an array
			$recordarray = array();
			
			if( isset( $sqlcolumn1 ) )
			{
				eval('$data = $record->$sqlcolumn1;');
				$recordarray[$column1] = $data;
			}
			// pass record to c2pf_categorise
			c2pf_categorise( $csv,$pro,$spe,$set,$filename,$record,$output,$recordarray );
		}
	
		if( $output )
		{
			c2pf_mes( 'Category Creation Complete','The plugin is finished processing categories.' );
		}
	}
}
		
# Builds Category Array 
function c2pf_categorise( $csv,$pro,$spe,$set,$filename,$record,$output,$recordarray )
{
	$catarray = array();

	// set default category
	$catarray[0] = 1;

	// single default category setup
	if( isset( $csv['singlecategory'] ) && !empty( $csv['singlecategory'] ) && $csv['singlecategory'] != 'NA' )
	{
		$catarray[0] = $csv['singlecategory'];
	}
	else
	{
		// is a splitter column setup  $csv['specials']['col']['cats_col']
		if( isset( $csv['specials']['col']['cats_col'] ) && isset( $csv['specials']['state']['cats_col'] ) && $csv['specials']['state']['cats_col'] == 'On' )
		{
			// explode resulting string - pass data value of the single column
			$splitcats = explode('/',$recordarray[ $csv['singlecategory'] ],3);
			
			// loop through resulting array and do wp_create_category for each
			$counter = 0;
			foreach( $splitcats as $id=>$cat )
			{
				$cat = c2pf_categoryencoding( $cat, $set,'category' );
	
				// put the resulting category id into array replacing old value
				$catarray[$counter] = wp_create_category( $cat );
				++$counter;
			}
		}
		else
		{
			// group one only at this time
			if( isset( $csv['categories'][0]['cat1'] ) && !empty( $csv['categories'][0]['cat1'] ) )
			{
				// use $csv category value to pull data/cat name from record array
				$categoryname = $recordarray[ $csv['categories'][0]['cat1'] ];
				
				// put value through encoding based on users category encoding settings
				$cat = c2pf_categoryencoding( $categoryname, $csv,'category' );
				
				// check for matching existing category - if not exist then create
				$catarray[0] = get_cat_ID( $cat );
				
				// if zero returned then no matching category exists, create it now
				if( $catarray[0] == 0 )
				{
					$catarray[0] = wp_create_category( $cat );
				}
			}
		}
	}
	
	// return results
	return $catarray;
}

# Prepares A String For Use As An SQL Column Name (removes spaces etc)
function c2pf_cleansqlcolumnname( $column )
{
	global $wpdb;
	$column = $wpdb->escape( $column );
	return str_replace( array( ",","/","'\'"," ",".",'-','#','_'),"", strtolower($column) );
}

# Takes A SQL Returned Record And Puts It Into Array With Key Being Column Titles		
function c2pf_recordarray( $csv,$record )
{
	$recordarray = array();
	foreach($csv['format']['titles'] as $column)
	{
		$sqlcolumn = c2pf_cleansqlcolumnname( $column );
		
		eval('$data = $record->$sqlcolumn;');
		
		$recordarray[$column] = $data;
	}
	return $recordarray;
}				
						
// add eci custom fields
function c2pf_postbuildmeta( $id, $filename, $recordid, $tablename )
{
	// original, updated, seperated
	update_post_meta($id, 'c2pf_poststate', 'original', true);// used to indicate post is related to ECI - also allows special treatment
	update_post_meta($id, 'c2pf_filename', $filename, true);// can use this in systematic post update to retrieve the right profile
	update_post_meta($id, 'c2pf_tablename', $tablename, true);// with this we don't need the csv file name to work with the table
	update_post_meta($id, 'c2pf_recordid', $recordid, true);// for linking back to the correct database record, used in updating
	update_post_meta($id, 'c2pf_lastupdate', date("Y-m-d H:i:s"), true);// used to compare to database table timestamp for auto updating	
}

// create excerpt
function c2pf_createexcerpt($str, $length)
{
	$c2pf_createexcerpt = c2pf_truncatestring( c2pf_striphtmltags($str), $length);
	if (strlen($str) > strlen($c2pf_createexcerpt)) {$c2pf_createexcerpt .= "...";}
	return $c2pf_createexcerpt;
}

# strip html tags
function c2pf_striphtmltags( $str )
{
	$untagged = "";
	$skippingtag = false;
	for ($i = 0; $i < strlen($str); $i++) 
	{
		if (!$skippingtag) 
		{
			if ($str[$i] == "<") 
			{
				$skippingtag = true;
			} 
			else
			{
				if ($str[$i]==" " || $str[$i]=="\n" || $str[$i]=="\r" || $str[$i]=="\t") 
				{
					$untagged .= " ";
				}
				else
				{
					$untagged .= $str[$i];
				}
			}
		}
		else
		{
			if ($str[$i] == ">") 
			{
				$untagged .= " ";
				$skippingtag = false;
			}		
		}
	}	
	
	$untagged = preg_replace("/[\n\r\t\s ]+/i", " ", $untagged); // remove multiple spaces, returns, tabs, etc.
	
	if (substr($untagged,-1) == ' ') { $untagged = substr($untagged,0,strlen($untagged)-1); } // remove space from end of string
	if (substr($untagged,0,1) == ' ') { $untagged = substr($untagged,1,strlen($untagged)-1); } // remove space from start of string
	if (substr($untagged,0,12) == 'DESCRIPTION ') { $untagged = substr($untagged,12,strlen($untagged)-1); } // remove 'DESCRIPTION ' from start of string
	
	return $untagged;
}

# truncate string to a specific length
function c2pf_truncatestring( $string, $length )
{
	if (strlen($string) > $length) 
	{
		$split = preg_split("/\n/", wordwrap($string, $length));
		return ($split[0]);
	}
	return ( $string );
}

// Adds A Notification
function c2pf_notifications( $filename,$message,$button,$priority )
{
	// no longer in use will be removed soon
}

# Applys Encoding To Entire $my_post Object Based On Settings
function c2pf_postencoding( $csv,$my_post,$set )
{	
	return $my_post;
}

# Converts Special Characters Using Correct Encoding Values For Permalinks
function c2pf_encodingclean_permalinks($title) 
{
    return $title;
}

# Converts Special Characters Using Correct Encoding Values For Content
function c2pf_encodingclean_content( $content) 
{
    return $content;
}

# Changes $my_post Object To Reflect The Adoption Of Existing Post Not A New Post Being Updated
function c2pf_adopt( $adoptpostid,$my_post )
{
	return $my_post;
}
			
# if duplicate posts found - attempts to adopt if user has activated adoption
function c2pf_postadoption( $duplicatearray,$recordarray,$csv )
{
	return false;
}
			
# Checks For Existing Posts That May Be A Duplicate And Avoids Duplicate Titles
function c2pf_duplicateposts( $csv,$my_post,$filename,$set )
{
	global $wpdb;
	
	// create array for storing duplicate post id
	$duplicatearray = array();
	
	// start variable for outputting to text file
	$text = 0;
	
	// start duplicate counter ( number of different posts )
	$dups = 0;
	
	// start duplicate parts counter ( number of check methods returning duplicate )
	$parts = 0;
	
	// variable for post name will print message to text file about outcome ( true or false)
	$postname = false;
	
	// variable used for numbering text file rows
	$rows = 0;
		
	$title = $my_post['post_title'];
	
	$postname = sanitize_title( $title );

	// if post name set - do a check to ensure that it is unique
	if( isset( $my_post['post_name'] ) )
	{	
		$name = $my_post['post_name'];
		
		// execute select query to select all records with current posts name
		$r = $wpdb->get_results("SELECT ID,post_title FROM " .$wpdb->prefix . "posts WHERE post_name = '$name'", OBJECT);
		
		if( $wpdb->num_rows > 0 )
		{		
			// count number of rows returned to equal duplicate matches
			$dups = $dups + $wpdb->num_rows;

			++$parts;
			
			// set $postname to true - puts message in txt file
			$postname = true;
	
			// add matching records to text file for troubleshooting
			foreach( $r as $p )
			{
				// add each id to array - later we use it for post adoption
				$duplicatearray[] = $p->ID;
				
				// add entry to text file with post id
				$text .= $rows . ' Post ID: '. $p->ID . ' Type: Post Name (custom)';
			}			
		}
	}
	else// run the same check by using posts title
	{		
		$r = $wpdb->get_results("SELECT ID,post_title FROM " .$wpdb->prefix . "posts WHERE post_name = '$postname'", OBJECT);

		if( $wpdb->num_rows > 0 )
		{
			$dups = $dups + $wpdb->num_rows;
			
			++$parts;
			
			// set $postname to true - puts message in txt file
			$postname = true;
			// add matching records to text file for troubleshooting
			foreach( $r as $p )
			{
				$duplicatearray[] = $p->ID;
				$text .= $rows . ' Post ID: ' . $p->ID . ' Type: Post Name (default)';
			}			
		}
	}
	
	// check for duplicate title (not permalink/post name)
	$records = $wpdb->get_results("SELECT ID,post_title FROM " .$wpdb->prefix . "posts WHERE post_name = '$postname'", OBJECT);

	if( $wpdb->num_rows > 0 )
	{
		$dups = $dups + $wpdb->num_rows;
		
		++$parts;
		
		// set $postname to true - puts message in txt file
		$postname = true;
		// add matching records to text file for troubleshooting
		foreach( $r as $p )
		{
			$duplicatearray[] = $p->ID;
			$text .= $rows . ' Post ID: ' . $p->ID . ' Type: Title';
		}			
	}	
	
	// if we have a possible duplicate write it to text file
	if( $dups > 0 )
	{
		// add the checks statistics
		$text .= date( "Y-m-d H:i:s", time() ).' - Existing Posts Matched: '. $dups .'<br />';
		$text .= date( "Y-m-d H:i:s", time() ).'Total Seperate Parts Matches: '. $parts .'<br />';
		
		c2pf_log( 'Create Post Duplicate Check','post created with id '.$my_post['ID'].' with title '.$title.' is considered a duplicate',$filename,$set,'Low' );	
		
		return true;
	}
	else
	{
		return false;
	}
}

# Decides Final Post Status
function c2pf_poststatus( $csv,$my_post )
{
	$timenow = strtotime( date("Y-m-d h:i:s") );
	$timenow + 5;// advance the current date
	$timeset = strtotime( $my_post['post_date'] );
					
	if( $timeset > $timenow )
	{
		$my_post['post_status'] = 'future';
	}
	elseif( $timeset < $timenow )
	{
		$my_post['post_status'] = $csv['poststatus'];
	}			
	
	return $my_post;
}

# Returns Array Holding Unique Key Columns Data Values For Giving Record
function c2pf_uniquekey( $csv,$recordarray )
{
	$uniquearray = array();
	if( isset( $csv['updating']['key1'] ) ){ $uniquearray[0] = $csv['updating']['key1']; };
	if( isset( $csv['updating']['key2'] ) ){ $uniquearray[1] = $csv['updating']['key2']; };
	if( isset( $csv['updating']['key3'] ) ){ $uniquearray[2] = $csv['updating']['key3']; };
	return $uniquearray;
}
			
# Creates Custom Fields Meta For All In One SEO If User Has Activated
function c2pf_allinoneseo_meta( $csv,$recordarray,$designarray,$id )
{				
}

# If "allow_url_fopen" not allows on server by ini, we use this curl function instead
function c2pf_curlthefilecontents( $url ) 
{
    $c = curl_init();
	
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	
    curl_setopt($c, CURLOPT_URL, $url);
	
    $contents = curl_exec($c);
	
    curl_close($c);

    if ($contents) 
	{
        return $contents;
    }
    
    return false;
}

# Replaces Tokens In Post Title With Actual Data
function c2pf_strreplacetokens($value,$data,$column)
{
	$token1 = '+'. $column .'+';
	$value = str_replace($token1, $data, $value);
	$token2 = 'x'. $column .'x';
	$value = str_replace($token2, $data, $value);
	return $value;
}

# Populates Giving Design Code With Records Data And Returns The designarray
function c2pf_populatedesign( $designarray, $recordarray, $csv )
{
	// loop through columns
	foreach( $csv['format']['titles'] as $column )
	{			
		// put columns data value for current record into $data
		$data = $recordarray[ $column ];
		
		// get database table version of csv file column name
		$sqlcolumn = c2pf_cleansqlcolumnname( $column );	

		// perform all token string replace actions here - standard post first
		$designarray['title'] = c2pf_strreplacetokens( $designarray['title'],$data,$column );
		$designarray['content'] = c2pf_strreplacetokens( $designarray['content'],$data,$column );
				
		// check if aioseo values were saved also - user may not have entered templates
		if( isset( $designarray['seotitle'] ) && !empty( $designarray['seotitle'] ) )
		{
			$designarray['seotitle'] = str_replace('+'. $column .'+', $data, $designarray['seotitle']);
			$designarray['seotitle'] = str_replace('x'. $column .'x', $data, $designarray['seotitle']);
		}
		
		if( isset( $designarray['seodescription'] ) && !empty( $designarray['seodescription'] ) )
		{
			$designarray['seodescription'] = str_replace('+'. $column .'+', $data, $designarray['seodescription']);	
			$designarray['seodescription'] = str_replace('x'. $column .'x', $data, $designarray['seodescription']);	
		}
	}				
	
	return $designarray;
}

# Applys Encoding To Categories If Activated
function c2pf_categoryencoding( $category, $set )
{
	return $category;
}
	
# returns full file name with blog prefix - requires current filename
function c2pf_wptablename( $filename )
{
	global $wpdb;
	$csvfileChunks = explode(".", $filename);
	$tablename = $csvfileChunks[0];
	$tablename = str_replace ( '-' , '' ,  $tablename );// remove hyphens
	$tablename = str_replace ( '_' , '' ,  $tablename );// remove underscores
	$tablename = str_replace ( ' ' , '' ,  $tablename );// remove underscores
	$tablename = strtolower( $tablename );
	return $wpdb->prefix . $tablename;
}

// creaqtes a temporary post - eventually is updated during post creation process
function c2pf_createbasepost($postdate,$postdategmt,$designarray,$status)
{
	$my_post = array();// start post array
	$columncounter = 0;// keep track of the column id
	// create an empty post starting with users wysiwyg creation - this is so we can use the POST ID from here on
	$my_post['post_date'] = $postdate;
	$my_post['post_date_gmt'] = $postdategmt;
	$my_post['post_title'] = 'CSV2POST Base Post';
	$my_post['post_content'] = 'CSV 2 POST creates a base post then updates it to complete the Post Creation procedure. 
	Please refresh the page to ensure that you never opened the post while ECI was creating it, if no changes happen after refresh
	simply delete this post. If you find many of these in your blog please report it to WebTechGlobal.';
	$my_post['post_status'] = $status;
	$my_post['ID'] = wp_insert_post( $my_post );
	
	if( $my_post['ID'] )
	{
		return $my_post;
	}
	else
	{
		return false;
	}
}

# Starts A Timer - Used To Time Scripts
function c2pf_microtimer_start()
{
	list($utime, $time) = explode(" ", microtime());
	return ((float)$utime + (float)$time);
}
?>