<?php
##########################################################################
####  Functions For Data Import + Export + Manipulation (admin only)  ####
##########################################################################

# Runs A Data Import Event - $total will equal FALSE or value to force a stop
function c2pf_dataimport( $filename, $output, $event, $set )
{
	c2pf_log( 'Import Started','Data '.$event.' started',$filename,$set,'Low' );

	c2pf_pearcsv_include();
	
	global $wpdb;
	
	$pro = get_option('c2pf_pro');
	$csv = get_option( 'c2pf_' . $filename );
	$spe = get_option('c2pf_spe');		

	// get projects speed profile name ( not type )
	$spepro = $pro[$filename]['speed'];
	
	// used collected name to get speed profiles configuration into variables
	$label = $spe[$spepro]['label'];// needed if output is true
	$import = $spe[$spepro]['import'];// number of records to import in a single event
	$update = $spe[$spepro]['update'];// number of records to update in a single event
	$type = $spe[$spepro]['type'];// type of speed profile - determines out
	
	// get current file date
	$stamp = c2pf_filetime( $filename,$pro,$csv,$set );

	// establish previous import progress - used to skip records in loop
	$progress = c2pf_progress( $filename );
	
	// used to compare against event limit on this event only
	$recordsprocessed = 0;

	// records actually looped - on this event only
	$recordslooped = 0;
	
	// csv rows imported to create database record - used for interface output only
	$updatesuccess = 0;
	$updatefailed = 0;
	$importsuccess = 0;
	$importfailed = 0;
	$updateresult = 0;

	// use pear to read csv file
	$conf = File_CSV::discoverFormat( $pro[$filename]['filepath'] );
	
	// apply stored seperator
	$conf['sep'] = $csv['format']['seperator'];		
	$conf['quote'] = $csv['format']['quote'];
		
	// set limit
	if( $event == 'import' )
	{
		$max = $import;
	}
	elseif( $event == 'update' )
	{
		$max = $update;
	}
	
	// loop through records until speed profiles limit is reached then do exit
	while ( ( $record = File_CSV::read( $pro[$filename]['filepath'], $conf ) ) && $recordsprocessed < $max ) 
	{		
		// skip first record - also skip done rows by using more or equal too
		if( $recordslooped != 0 && $recordslooped > $progress )
		{
			// count actual records processsed after progress total looped through
			++$recordsprocessed;
	
			$profilecolumnid = 0;
			
			// do a select query using every column - ensure no duplicate - if it exists already we drop it $importfailed + 1
			if( $set['allowduplicaterecords'] == 'Yes' ){ $selectfound = $wpdb->query( c2pf_sqlselect( $record, $filename, 'whereall' ) ); }
			
			// if a record was found in project table matching current processed record, add it to failed count
			if( isset( $selectfound ) && $selectfound != false )
			{
				++$pro[$filename]['rowsinsertfail'];
				++$importfailed;
			}
			else
			{

				$sqlmiddle = c2pf_sqlinsert_middle( $record,$csv['format']['columns'],$stamp['current'],$csv );
				
				$insertquery = $csv['sql']['insertstart'] . $sqlmiddle;
				
				$insert = $wpdb->query( $insertquery );
				
				// increase statistics for success or fail
				if( $insert === false )
				{
					c2pf_notifications( $filename,'Data import failed due to SQL error,please seek support','NA',3 );	
					
					c2pf_adminmes( 'SQL Insert Error','The plugin attempted to run an SQL INSERT query
					but Wordpress returned false which usually indicates a problem. Please
					investigate this before running further data import events. The 
					SQL INSERT query is below:<br /><br />'.$insertquery.'','err' );
				}
				elseif( $insert === 0 )
				{
					++$pro[ $filename ]['rowsinsertfail'];
					++$importfailed;
				}
				elseif( $insert === 1 )
				{
					++$pro[ $filename ]['rowsinsertsuccess'];
					++$importsuccess;
				}	

				unset( $insertquery );
			}
		}
		
		// if total records processed hits event limit ( $import ) then exit loop
		if( $event == 'insert' && $recordsprocessed >= $import )
		{
			break;
		}
		
		++$recordslooped;
		
	}// end of while loop

	// now update project progress counters
	++$pro[ $filename ]['events'];
	
	// update csv array to save sql queries
	$csv['arraychange'] =  c2pf_arraychange( __LINE__,__FILE__ );
	update_option( 'c2pf_' . $filename, $csv );
	update_option('c2pf_pro',$pro);

	c2pf_log( 'Import','Imported:'.$importsuccess.' Import Failed:'.$importfailed.' Updated:Paid Support Edition Only, Updated Failed:Paid Support Edition Only ',$filename,$set,'Low' );	

	// on 100% success output result
	if( $output )
	{
		$outputmes = 'No problems were detected during the previous data '.$type.' event.<br />
		<br />
		Records Imported Successfully: '. $importsuccess .'<br />
		Records Import Failed: '. $importfailed .'<br />
		Records Updated Successfully: Paid Support Edition Only<br />
		Records Update Failed: Paid Support Edition Only<br />';
		
		$outputmes .= '
		<h3>More Actions</h3>
			<form method="post" name="c2pf_importstage_form" action="">  
				<input name="c2pf_filename" type="hidden" value="'.$filename.'" />
				Encoding To Apply:
				<select name="c2pf_encoding_importencoding" size="s">
					<option value="None">None</option>
					<option value="UTF8Standard">UTF-8 Standard Function</option>
					<option value="UTF8Full">UTF-8 Full (extra processing)</option>
				</select>
				<br /><br />
				<input class="button-primary" type="submit" name="c2pf_datatransfer_submit" value="Import More Data" />
			</form><br />';
			
		c2pf_mes( 'Data '.$type.' Success',$outputmes );
	}
}

# Builds Select Query - Selects Unique Key Column Values - ($type = standardselect,partofupdate )
function c2pf_sqlselect( $record, $filename, $type )
{
	$csv = get_option('c2pf_' . $filename);
	
	$col = 0;
	
	// start select columns
	$select = 'SELECT ';
	
	// start where part of query
	$where = ' WHERE ';
	
	// count how many keys are used
	$k = 0;
	
	foreach( $csv['format']['titles'] as $column )
	{		
		// if select is being done as part of an update event, we only want to select giving unique key columns
		if( $type == 'partofupdate' )
		{
			// is this column part of unique key ?
			if( isset( $csv['updating']['key1'] ) && $csv['updating']['key1'] == $column ){$select .= c2pf_cleansqlcolumnname($column);$key = true;++$k;}
			elseif( isset( $csv['updating']['key2'] ) && $csv['updating']['key2'] == $column ){$select .= c2pf_cleansqlcolumnname($column);$key = true;++$k;}
			elseif( isset( $csv['updating']['key3'] ) && $csv['updating']['key3'] == $column ){$select .= c2pf_cleansqlcolumnname($column);$key = true;++$k;}
			else{$key = false;} 
			
			// if column is 2nd,3rd or more then apply comma
			if( $k > 0 )
			{
				$select .= ',';
			}			
		}
		elseif( $type == 'standardselect' || $type == 'whereall' )
		{
			$select = '*';
		}

		// if part of unique column or $type is whereall add the column and data to where part of query
		if( $key == true || $type == 'whereall' )
		{
			if( $w > 0 )
			{
				$where .= ' AND ';
			}

			$where .= c2pf_cleansqlcolumnname( $column ) ." = '". $record[$col] ."'";
			
			++$w;
		}
		
		++$col;
	}	
	
	// put together parts of query
	$q = $select . ' FROM '. $csv['sql']['tablename'] . $where;
	
	// if there are no keys - display message and set notification that update attempted without keys
	// this should not be possible however it is in place should future updates allow update before checks are done
	if( $k == 0 )
	{
		c2pf_err( 'Select Attempt Failed','The CSV2POST project '. $filename .' attempted to build an SQL SELECT query
				as part of the data update process. However it appears that the project does not have a Unique Key
				setup. Setup a Unique Key or possibly switch of all Updating for your project.' );
	}
		
	return $q;	
}

# Builds SQL Update Query Using Passed Record - If No
function c2pf_sqlupdate( $record, $columns, $filename )
{		
	// not it free edition
	$q = 'UPDATE ' . c2pf_wptablename( $filename );	
	return $q;
}

// builds part of sql query that holds data - requires $record value from open csv file and $insertquery_start
function c2pf_sqlinsert_middle( $record, $totalcolumns,$filetime,$csv )
{		
	$insertquery = '(NOW(),'.$filetime.',';
	
	$columnid = 0;
	
	foreach( $record as $data )
	{			
		++$columnid;
		
		// does user want utf8 encoding on import
		if( $csv['importencoding'] == 'UTF8Standard' )
		{
			$data = utf8_encode( $data );
		}
		
		$insertquery .= "'" . mysql_real_escape_string( $data ) . "'";
		
		if( $totalcolumns != $columnid ){ $insertquery .= ","; }// apply comma until last column
	}
	
	$insertquery .= ')';
	
	return $insertquery;
}

# Drops Project Table - interface actioned with message output
function c2pf_deletetable( $filename )
{
	global $wpdb;

	$set = get_option( 'c2pf_set' );
	
	// get project table name
	$table_name = c2pf_wptablename( $filename );
	
	// drop existing table and display message
	$query = 'DROP TABLE '. $table_name .'';
	
	// run drop table query
	$result = $wpdb->query( $query );
	
	// 0 = success anything else is error
	if( $result === 0  )
	{		
		c2pf_log( 'Table Deleted','The table named '.$table_name.' was deleted',$filename,$set,'High' );	
		c2pf_notifications( $filename,'Project database table dropped/deleted','NA',1 );
		c2pf_mes('Table '.$table_name.' Deleted','All data and the table itself has been dropped. If you need to you may create the table again manually in the same way you deleted it.');
		return true;
	}
	else
	{
		c2pf_mes('Failed To Delete Table '.$table_name.'','The plugin could not delete your project table, please try again then seek support.');
		return false;
	}	
}

# Executes Giving SQL Query On External Database For Giving Project
function c2pf_blog2blogquery( $csv,$pro,$spe,$query,$filename )
{
	// not in free edition yet
}
	
# Create Project Database Table
function c2pf_createtable( $filename,$set )
{
	global $wpdb;

	c2pf_log( 'Created Table','A new database table was created for project '.$filename.'',$filename,$set,'Low' );	

	// get speed profile - check to see if type is blog2blog
	$spe = get_option( 'c2pf_spe' );
	
	$result = false;
	
	$existsalready = false;
	
	// get project table name
	$table_name = c2pf_wptablename( $filename );
	
	// get csv profile
	$csv = get_option( 'c2pf_' . $filename );
	
	// get project data array
	$pro = get_option( 'c2pf_pro' );
	
	// get speed profile type
	$type = $spe[ $pro[$filename]['speed'] ]['type'];
	
	// build select query to test tables existance and count alll records
	$selectcount = "SELECT COUNT(*) FROM ".$table_name;

	// does table already exist?  If so how many records does it hold?
	$count = $wpdb->get_var( $wpdb->prepare( $selectcount ) );
		
	// get plugin settings
	$set = get_option('c2pf_set');
		
	// automatically drop table if existing records less than acceptable drop
	if( $count > $set['acceptabledrop'] && $count != NULL )
	{
		c2pf_err('Existing Table Encountered','Your project file matches an existing
		table in your database and your acceptable record loss setting is '. $set['acceptabledrop'] .' so
		the plugin could not automatically delete the table because there are '. $count .' records in the table. You
		must decide to either delete the table manually using the Tools page or continue adding data to it by using the
		forms below.<br /><br />
		Please remember that you can change your Acceptable Records Loss number on the Settings page under Interface Configuration. If you
		are running tests you can increase the number to allow automatic delete at this point, everytime but be carefull for real projects.');
		
		$existsalready = true;
	}
	elseif( $count <= $set['acceptabledrop'] && $count != NULL )
	{	
		// drop existing table and display message
		$query = 'DROP TABLE '. $table_name .'';
		// does table already exist?  If so how many records does it hold?
		$count = $wpdb->get_var( $wpdb->prepare( $query ) );
		// run drop table query
		$result = $wpdb->query( $query );		
		c2pf_log( 'Table Deleted','Database table named '.$table_name.' was dropped',$filename,$set,'High' );	
		c2pf_err('Existing Table Deleted','Your project file matched an existing table in your database but has been deleted. It was deleted because 
				  your acceptable record loss setting is '. $set['acceptabledrop'] .' and the table had '. $count .' records.');
	}
	
	// attempt to create table if $existsalready = false
	if( $existsalready === false )
	{
		$table = "CREATE TABLE `". $table_name ."` (
		`freeedition` int(10) unsigned default NULL COMMENT '',
		`c2ppostid` int(10) unsigned default NULL COMMENT '',
		`c2pid` int(10) unsigned NOT NULL auto_increment,
		`c2pupdated` datetime NOT NULL COMMENT '',
		`c2pfiletime` datetime NOT NULL COMMENT '',";
		
		$columnid = 0;
		
		// loop through csv column titles, each one built as table column
		foreach( $csv['format']['titles'] as $column )
		{			
			++$columnid;
			
			// we need to prepare column names (no spaces or special characters etc)
			$sqlcolumn = c2pf_cleansqlcolumnname($column);	
						
			$table .= "`" . $sqlcolumn . "` text default NULL COMMENT '',";
		}
				
		// end of table
		$table .= "PRIMARY KEY  (`c2pid`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Table created by CSV 2 POST Free Edition';";								
								
		$createresult1 = $wpdb->query( $table );
		
		if( $createresult1 === false )
		{
			c2pf_log( 'Table Failed','A table named '.$table_name.' could not be made',$filename,$set,'Failure' );	
			c2pf_err('Failed To Create Table','Your project database table failed to be created. Please investigate this.');
		}
		else
		{
			c2pf_log( 'Table Created','A table named '.$table_name.' was created',$filename,$set,'Low' );	
			c2pf_mes('Created Project Database Table','Your project database table name is:'.$table_name.'');
		}
	}
}		

# Builds SQL Insert Query Start Based On CSV File Column Names
# Saves To CSV File Profile To Help Avoid Building Later
function c2pf_sqlinsert_start( $filename )
{
	$csv = get_option('c2pf_' . $filename);

	$insertquery = "INSERT INTO `" . $csv['sql']['tablename'] . "` (`c2pupdated`,`c2pfiletime`,";
	
	$columnid = 0;
	
	foreach( $csv['format']['titles'] as $column )
	{			
		++$columnid;
	
		// we need to prepare column names (no spaces or special characters etc)
		$sqlcolumn = c2pf_cleansqlcolumnname($column);	

		$insertquery .= "`" . $sqlcolumn . "`";
		
		if( $csv['format']['columns'] != $columnid ){ $insertquery .= ","; }// apply comma until last column
	}
	
	$insertquery .= ') VALUES ';
	
	// save query start to csv profile
	$csv['sql']['insertstart'] = $insertquery;
	$csv['arraychange'] =  c2pf_arraychange( __LINE__,__FILE__ );
	update_option( 'c2pf_' . $filename, $csv );
}

# counts total records in giving project table
function c2pf_counttablerecords( $filename )
{
	global $wpdb;
	
	$pro = get_option( 'c2pf_pro' );
	
	$query = "SELECT COUNT(*) FROM ". c2pf_wptablename( $filename ) . ";";
	
	$records = $wpdb->get_var( $query );
	
	if( $records )
	{
		$pro['records'] = $records;
		update_option( 'c2pf_pro', $pro );
		return $records;
	}
	else
	{
		return '0';
	}	
}

# Deletes All Giving Projects Posts, Resets Progress Data And Data Table
function c2pf_deleteprojectposts( $pro,$filename,$csv,$set )
{
	global $wpdb;

	c2pf_log( 'Delete Posts','The delete project post procedure started',$filename,$set,'High' );	

	// select records from project table where post id is not null
	$myrows = $wpdb->get_results( 'SELECT * FROM '. $csv['sql']['tablename'] .' WHERE c2ppostid IS NOT NULL OR c2ppostid != "0" LIMIT '.$set['querylimit'].'' );
	
	if( $pro[$filename]['rowsinsertsuccess'] > $set['querylimit'] )
	{
		c2pf_err( 'Multiple Events Required','The plugin is currently limited to deleting '.$set['querylimit'].' in a single event and your project appears to have
				'.$pro[$filename]['rowsinsertsuccess'].' records. There limit setting called "SQL Query Limit" and it exists to prevent hanging but can be increased on the 
				settings page in the advanced panel. Please press the Delete Project Posts button again to run another event and delete another 
				'.$set['querylimit'].' posts or less.' );
	}
	
	// loop through selected records - get post id - delete the post - set id to null in table
	if( $myrows )
	{
		$df = 0;// delete attempts failed
		$ds = 0;// delete attempts success
		$deleted = 0;// from blog - not count of changes made in project table
		$deletedfailed = 0;
		foreach( $myrows as $post )
		{
			$result = wp_delete_post( $post->c2ppostid, $force_delete = true );
							
			if( !$result )
			{ 
				++$df; 
			}
			else
			{
				++$ds; 
			}
			
			$query = 'UPDATE '. $csv['sql']['tablename'] .' SET c2ppostid = NULL WHERE c2ppostid = '. $post->c2ppostid .'';
			$result = $wpdb->query( $query );
		}
		
		// update project schedule
		$pro[$filename]['postscreated'] = $pro[$filename]['postscreated'] - $ds;
		
		c2pf_log( 'Delete Posts','The plugin deleted '.$df.' posts on request',$filename,$set,'High' );	

		// output results
		c2pf_mes( 'Delete Event Finished','This delete feature is provided in the fully paid support edition' );	
	}
	else
	{
		c2pf_mes( 'Delete Event Finished','No posts deleted. The plugin did not find any records in your project database table
				with a post id assigned to them. This indicates none of the records have been used to create posts.' );
	}
}
?>
