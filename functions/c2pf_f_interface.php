<?php
# Builds Form Menu Holding CSV File Columns - No Conditions Unlike The Other Menu Building Functions
function c2pf_csvcolumnmenu_updatekey( $filename, $objectid )
{
	$csv = get_option( 'c2pf_'.$filename );
	echo '<select name="c2pf_columnid_'. $objectid .'" size="1">';
	echo '<option value="NA">Paid Edition Only</option>';
	$i = 0;
	foreach( $csv['format']['titles'] as $column )
	{		
		echo'<option value="NA">'. $column .'</option>';++$i;
	}
	echo '</select>';
}	

# Builds Form Menu Holding CSV File Columns - No Conditions Unlike The Other Menu Building Functions
function c2pf_csvcolumnmenu( $filename, $objectid )
{
	$csv = get_option( 'c2pf_'.$filename );
	echo '<select name="c2pf_columnid_'. $objectid .'" size="1">';
	echo '<option value="NA">Not Required</option>';
	$i = 0;
	foreach( $csv['format']['titles'] as $column )
	{		
		echo'<option value="'. $column .'">'. $column .'</option>';++$i;
	}
	echo '</select>';
}	

# Builds A Single Menu Form Object With Its Name Being Part Of Arguments Giving
function c2pf_csvcolumnmenu_specialfunctions( $filename, $objectid )
{
    // first get csv profile
	$csv = get_option( 'c2pf_' . $filename );

	// then we list all column titles from the profile with their ID in the form
	echo '<select name="c2pf_spec_'. $objectid .'" size="1">';
		
		if( $objectid == 'thumbnail' )
		{
			echo '<option value="NA">Sorry This Currently Has A Bug It Will Be Fixed Soon</option>';
		}
		else
		{
			echo '<option value="NA"> Not Required In My Project </option>';
			// add all csv file column names to the menu as items
			foreach( $csv['format']['titles'] as $column )
			{	
				if( isset( $csv['specials']['state'][$objectid.'_col'] ) 
				&& $csv['specials']['state'][$objectid.'_col'] == 'On' 
				&& isset( $csv['specials']['col'][$objectid.'_col'] )
				&& $csv['specials']['col'][$objectid.'_col'] == $column )
				{ 
					$selected = ' selected'; 
				}
				else
				{ 
					$selected = '';
				}
				
				echo '<option value="'. $column .'" '. $selected .'>'. $column .'</option>';
			}
		}
	
	echo '</select>';
}	

# Displays A Table Holding Projected Dates Based On Current Incremented Date Settings
function c2pf_projecteddates_incremental( $set )
{
	$rowswanted = 10;
	$rowsadded = 0;
	
	$table = '<table class="widefat post fixed">		
	<tr>
		<td width="25"></strong></td>
		<td>Standard Date</td>
		<td>GMT Date</td>
		<td>Incremented Seconds</td>
	</tr>';
	
	$currentinctime = time();
	
	for ($rowsadded = 1; $rowsadded <= $rowswanted; $rowsadded++) 
	{		
		$date1 = '10th';
		$date2 = '10th';
		$date3 = '10th';

		$increment = rand( $set['incrementstart'], $set['incrementend'] );
		$currentinctime = $currentinctime + $increment;
		$my_post['post_date'] = date("Y-m-d H:i:s", $currentinctime);	
		$my_post['post_date_gmt'] = gmdate("Y-m-d H:i:s", $currentinctime);
		
		$table .= '
		<tr>
			<td width="25">'.$rowsadded.'</strong></td>
			<td>'.date("Y-m-d H:i:s", $currentinctime).'</td>
			<td>'.gmdate("Y-m-d H:i:s", $currentinctime).'</td>
			<td>'.$increment.'</td>
		</tr>';		
	}		
	
	$table .= '</table>';
	return $table;
}
                    
# Displays A List Of Tokens For Use In WYSIWYG Editor - Based On Column Titles
function c2pf_displaytokenlist( $type )
{
	global $wpdb;

	// include PEAR CSV
	c2pf_pearcsv_include();
	
	$c2p = get_option('c2pf_set');
	$pro = get_option( 'c2pf_pro' );
	$csv = get_option( 'c2pf_'.$pro['current'] );

	$recordscount = 0;// rows looped through on each event for fast skipping etc, not a counter of rows processed
		
	$datachecked = array();// we use to track what columns have been checked in the event of null values
	
	$datacomplete = 0;// count number of entries made to $datachecked array - keep going until it equals columns
	
	$filepath = C2PCSVFOLDER . $pro['current'];
	
	$conf = File_CSV::discoverFormat( $filepath );

	$conf['sep'] = $csv['format']['seperator'];		
	$conf['quote'] = $csv['format']['quote'];

	while ( ( $record = File_CSV::read( $filepath, $conf ) ) ) 
	{		
		if( $recordscount != 0 )
		{
			$columnid = 0;
			foreach( $record as $data )
			{		
				// ensure column has not already been checked and set in array
				if( !isset( $datachecked[$columnid] ) )
				{
					// ensure field value is not null - if it is do not insert
					if( $data != NULL && $data != '' && $data != ' ' && !empty( $data ) )
					{
						// check if data value is a url - if it is then list it as a different token
						if( $type == 'tokens' )
						{
							if( c2pf_valid_url($data) )
							{							
								// set column id in array to prevent it being rechecked
								$datachecked[$columnid] = 'url';
								// increase $datacomplete - when it matches column count then we have all we need
								++$datacomplete;
								// display url token
								echo '  x' . $csv['format']['titles'][$columnid] . 'x  <br /><br />'; 
							}
							elseif( is_numeric($data) )
							{							
								$datachecked[$columnid] = 'numeric';
								++$datacomplete;
								echo '  +' . $csv['format']['titles'][$columnid] . '+  <br /><br />'; 
							}
							else
							{
								$datachecked[$columnid] = 'string';
								++$datacomplete;
								echo '  +' . $csv['format']['titles'][$columnid] . '+ <br /><br />'; 
							}
						}
						elseif( $type == 'shortcodes' )
						{
							$datachecked[$columnid] = 'NA';
							++$datacomplete;
							echo '[c2plab column="' . $csv['format']['titles'][$columnid] . '" Paid Edition Only]<br /><br />'; 
						}						
						elseif( $type == 'shortcodeslabel' )
						{
							$datachecked[$columnid] = 'NA';
							++$datacomplete;
							echo '[c2plab column="'.$csv['format']['titles'][$columnid].'" label="Your Label: " nullaction="delete/swap" nullswap="tbc"]<br /><br />';
						}
					}
				}
				++$columnid;
			}
			
			// if we hit the maximum process number or all entries have been made			
			if( $recordscount == 10 || $datacomplete == $csv['format']['columns'] ){ ++$recordscount; break;}				
		}
		
		++$recordscount;
	}
}

# Creates Menu Holding Encoding Options
function c2pf_encodingmenu( $set,$c,$part )
{
	$s = 'selected="selected"';
	?>
    <select name="c2pf_encoding_<?php echo $part;?>" size="s">
    	<option value="None" <?php if( $c == 'None' ){echo $s;}?>>Paid Editions Only</option>
    </select>
	<?php 
}

# Menu For Selecting Optional Data Effects To Custom Field Values
function c2pf_datafunctions_customfields( $objectid )
{
    // first get csv profile
	$menu = '
	<select name="fun_'. $objectid .'" size="1">
		<option value="NA">NA</option>
		<option value="keywordgenerator">Keyword Generator</option>
	</select>';
	
	return $menu;
}	

# Returns Menu For Selecting CSV Columns On Custom Fields Form
function c2pf_csvcolumnmenu_customfields( $csv, $objectid, $cf )
{
	// then we list all column titles from the profile with their ID in the form
	$cols = 0;

	// add all csv file column names to the menu as items
	$item = '';
	foreach( $csv['format']['titles'] as $column )
	{	
		// check if the current column is setup for the passed custom field for selected 
		if( isset( $csv['customfields'][$cf]['col'] ) && $csv['customfields'][$cf]['col'] == $column )
		{ 
			$selected = ' selected="selected"'; 
		}
		else
		{ 
			$selected = '';
		}
		
		$item .= '<option value="'. $column .'" '. $selected .'>'. $column .'</option>';
		
		++$cols;
	}
	
		
	$menu = ' <select name="col_'. $objectid .'" size="1">
				<option value="NA">NA</option>';
	
	$menu .= $item;
	
	$menu .= '</select>';
	
	return $menu;
}	

# Lists Available CSV Files With Checkbox
function c2pf_csvfilelist_newproject( $set )
{
	$pro = get_option( 'c2pf_pro' );
	
	$available = 0;
	
	// start tab
	echo '<table>';
				
	// if users custom paths exist, loop through those first
	if( $pat = get_option('c2pf_pat') )
	{
		foreach( $pat as $p )
		{
			// open each directory
			@$csvfiles_diropen = opendir( $p['path'] );
			
			if( !$csvfiles_diropen )
			{?>	
				<tr class="first">
					<td class="first b b-posts"><input type="radio" name="NA" value="NA" disabled="disabled" /></td>
					<td class="t posts">A Directory Is Invalid Or No Permission For Access</td>
				</tr>
				
			<?php 
			}
			else
			{
				// loop through this directories csv files
				while( false != ( $oldfilename = readdir( $csvfiles_diropen ) ) )
				{
					// do not show file if already being used in project
					if( !isset( $pro[$oldfilename] ) )
					{
						if( ($oldfilename != ".") and ($oldfilename != "..") )
						{
							$fileChunks = explode(".", $oldfilename);
							
							// ensure file extension is csv
							if( isset( $fileChunks[1] ) && $fileChunks[1] == 'csv')
							{
								// preset $cleanedfile variable to be the current value
								$newfilename = $oldfilename;
			
								// clean the filename
								$newfilename = c2pf_cleanfilename( $oldfilename );			
			
								// correct slashes to prevent error on the rename function
								$p1 = '"\"'; $p2 = '"/"';
								$oldpath = str_replace ( $p1 ,$p2 , $p['path'].$oldfilename );// remove hyphens
								$newpath = str_replace ( $p1 ,$p2 ,$p['path'].$newfilename );// remove hyphens			
			
								// if returned clean file name is different from original then apply a file rename
								if( $oldfilename != $newfilename )
								{
									// store old file name for auto checking for a new file being placed
									// precleanfilename should only be set if a change happens, later its existance
									// will effect procedures
									$csv['precleanfilename'] = $oldfilename;
									$csv['precleanfilepath'] = $p['path'].$newfilename;
									update_option( 'c2pf_'.$newfilename, $csv );
									
									// does new planned path already exist
									if ( file_exists( $newpath ) ) 
									{
										$newpathexists = true;
										$newpathdeleted = false;
										
										// delete existing file on our new planned path
										if( unlink( $newpath ) )
										{
											$newpathdeleted = true;
										}
										else
										{
											$newpathdeleted = false;
										}
									}
									else
									{
										$newpathexists = false;
									}
									
									// either apply rename or report failure
									if( $newpathexists && $newpathdeleted || !$newpathexists )
									{
										if( rename( $oldpath, $newpath ) )
										{
											c2pf_log( 'Files','File '.$oldfilename.' renamed to '.$newfilename.'','Operation',$set,'High' );
										}
										else
										{
											c2pf_log( 'Files','File '.$oldfilename.' failed to be renamed to '.$newfilename.'','Operation',$set,'Failure' );
										}
									}
									elseif( $newpathexists && !$newpathdeleted )
									{
										c2pf_log( 'Files','File '.$oldfilename.' failed be deleted','Operation',$set,'Failure' );
									}
									else
									{
										c2pf_log( 'State','Unexpected state in new project file list','Operation',$set,'Failure' );
									}
								}
								?>
                                
								<tr class="first">
									<td class="first b b-posts"><input type="radio" name="c2pf_filepath" value="<?php echo $newpath;?>" checked  /></td>
									<td class="t posts"><?php echo $p['path'].$newfilename;?></td>
								</tr>
                                
								<?php
								++$available;
							}
						}
					}
				}
				
				// close this directory
				closedir($csvfiles_diropen); 						
				
			}
		}
	}

	echo '</table>'; 
}

# Displays Main Project Progress Data On Small Table
function c2pf_smallprogresstable( $filename,$pro,$csv,$spe,$set )
{
	// if project is using spreadout speed profile - display status
	$message = '';
	if( $spe[ $pro[ $pro['current'] ]['speed'] ]['type'] == 'spreadout' )
	{
		$message = 'status: <strong>'.$pro[$pro['current']]['status'].'</strong>';
	}
	
	// display file date information - progress details - update requirement etc
	echo '
	<table class="widefat post fixed">
		<tr>
			<td width="150"><strong>Project Progress Table</strong></td>
			<td width="150">(speed type: <strong>'.$spe[ $pro[ $pro['current'] ]['speed'] ]['type'].'</strong>)</td>
		</tr>
		<tr>
			<td>Imported Records: '.$pro[$pro['current']]['rowsinsertsuccess'].'</td>
			<td>Import Records Failed: '.$pro[$pro['current']]['rowsinsertfail'].'</td>
		</tr>
		<tr>
			<td>Posts Created: '.$pro[$pro['current']]['postscreated'].'</td>
			<td>Posts Updated: '.$pro[$pro['current']]['postsupdated'].'</td>
		</tr>
	</table>';
	
	$stamp = c2pf_filetime( $pro['current'],$pro,$csv,$set );
}

# Post Box 
function c2pf_postboxabout( $title,$txtfile,$set )
{
	if( isset( $set['aboutpanels'] ) && $set['aboutpanels'] == true )
	{
		echo '<br /><div class="postbox closed"><div class="handlediv" title="Click to toggle"><br /></div>
		<h3>'.$title.'</h3><div class="inside">Full support is only providing in the paid edition. Installation and video tutorial support is available for the free edition.</div></div>';
	}
}

# Builds Form Menu For Design Selection Per Category On Conditions Stage
function c2pf_maindesignsmenu( $csv )
{
	$des = get_option('c2pf_des');
	
	$sel = '';
	
	// apply id to object
	$menu = '<select name="c2pf_designmain" size="1"><option value="Default">Main Project Design</option>';
	
	if( $des )
	{
		foreach( $des as $key=>$d )
		{ 
			if( $key != 'arraydesc' )
			{
				// apply selected value to current save
				$sel = '';
				
				if( isset( $csv['maindesign'] ) && $csv['maindesign'] == $key ) 
				{				
					$sel = 'selected="selected"';
				}
				
				$menu .= '<option value="Default" '.$sel.'>'.$key.'</option>'; 
			}
		}   
	}
	else
	{
		$menu .= '<option value="Default">No Designs Created</option>'; 
	}
	
	$menu .= '</select>';
	return $menu;
}

# Builds Form Menu For Design Selection Per Category On Conditions Stage
function c2pf_categorydesignsmenu( $id, $csv, $category )
{
	return 'Paid edition only';
}

# Creates List Of Categories And Design Menus For Applying Per Category Design Conditions
function c2pf_listcategorydesigns( $csv )
{	
	$args = array(
	'type'                     => 'post',
	'hide_empty'               => 0,
 	'hierarchical'             => 0,
	'orderby'                  => 'name',
	'order'                    => 'ASC',
	'taxonomy'                 => 'category',
	'pad_counts'               => false );
	
	$cats = get_categories( $args );
	
	echo '<table class="widefat post fixed">
	<tr><td width="200"><strong>Categories (parent only)</strong></td><td><strong>Designs</strong></td></tr>';
	
	$i = 0;
	
	foreach( $cats as $c )
	{	
		if( $c->parent < 1 && $c->name != 'Uncategorized' )
		{
			echo '<tr><td><input name="category'.$i.'" type="text" value="'.$c->name.'" size="50" maxlength="100" readonly="true" /></td><td>'.c2pf_categorydesignsmenu( $i,$csv,$c->name ).'</td></tr>';
			++$i;
		}
	}	
	
	// include number of categories for the processing loop
	echo '<input name="catcount" type="hidden" value="'.$i.'" />';
	
	echo '</table>';
}

# Echos Link For Post Box Header
function c2pf_postboxlink( $url,$title )
{
	echo '<span class="postbox-title-action"><a href="'.$url.'" target="_blank" class="edit-box open-box">'.$title.'</a></span>';
}

# Builds Advice Based On Current Plugin And Project Condition
function c2pf_recommendation( $pro,$csv,$spe )
{
	$rec = 'no recommendations at this time';
	return $rec;
}

# Form Menu Item Selected Decision 
function c2pf_selected( $valueone, $valuetwo ){if($valueone==$valuetwo){echo'selected="selected"';}}

# Builds Menu Of Blog Categories For Form
function c2pf_categoriesmenu( $filename )
{	
	$csv = get_option('c2pf_'.$filename);
	
	// get blogs categories
	$cats = get_categories('hide_empty=0&echo=0&show_option_none=&style=none&title_li=');

	echo '<form method="post" name="c2pf_singlecategory_form" action="">            

    <label>Category<select name="c2pf_category" size="1">';
			
	echo '<option value="NA" '.$sel.'>Not Required</option>';
	
	foreach( $cats as $c )
	{ 
		// apply selected value to current save
		if( isset( $csv['singlecategory'] ) && $csv['singlecategory'] == $c->term_id ) 
		{
			$selected = 'selected="selected"';
		}
		
		echo '<option value="'.$c->term_id.'">'.$c->cat_name.'</option>'; 
	}      
	
	echo '</select></label>
		<input class="button-primary" type="submit" name="c2pf_singlecategory_submit" value="Submit" />
	</form>';
} 

# Form Object Listing All Paths - Default And Custom
function c2pf_pathsmenu()
{
	if( $pat = get_option('c2pf_pat') )
	{
		echo '<select name="c2pf_path">';
		
		foreach( $pat as $key=>$p )
		{
			echo '<option value="'. $key .'">'. $p['name'] .'</option>';
		}
		
        echo '</select>';			
	}
	else
	{
		echo 'CSV file paths data does not appear to be installed, if you upload now
		your CSV file will be placed in the default directory. The plugin will also
		attempt to install the path data.<br /><br />';
	}
}

# Lists Event Speed Profiles In A Table With Form Radio Buttons
function c2pf_speedprofilelist()
{
	$spe = get_option('c2pf_spe');
	
	if( $spe )
	{
		$table = '<table>';
		
		foreach( $spe as $k=>$item )
		{
			if( $k != 'arraydesc' )
			{   			   
				$table .= 
				'
					<tr class="first"><td class="b b-comments">
						<input type="radio" name="c2pf_speedname" value="'.$k.'" checked  /></td>
						<td class="last t comments">'.$item['label'].'</td>
					</tr>			
				';
			}
		}
									
		$table .= '</table>';
		
		echo $table;
	}
	else
	{
		echo 'No event speed profiles were found. They should have been installed when activating the plugin.';
	}
}

# Displays Standard Wordpress Message
function c2pf_mes( $title,$message )
{
	echo '<div id="message" class="updated fade"><strong>'.$title.'</strong><p>'. $message .'</p></div>';
}

# Displays Wordpress Error Message
function c2pf_err( $title,$message )
{
	echo '<div id="message" class="updated fade"><strong>'.$title.'</strong><p>'. $message .'</p></div>';
}

# Adds Wordpress Admin Style Sheets And Control Panel Too All Pages
function c2pf_header()
{?>       
	<link rel='stylesheet' href='<?php echo get_bloginfo( 'url' );?>/wp-admin/load-styles.php?c=1&amp;dir=ltr&amp;load=dashboard,plugin-install,global,wp-admin&amp;ver=030f653716b08ff25b8bfcccabe4bdbd' type='text/css' media='all' />
	<link rel='stylesheet' id='thickbox-css'  href='<?php echo get_bloginfo( 'url' );?>/wp-includes/js/thickbox/thickbox.css?ver=20090514' type='text/css' media='all' />
	<link rel='stylesheet' id='colors-css'  href='<?php echo get_bloginfo( 'url' );?>/wp-admin/css/colors-fresh.css?ver=20100610' type='text/css' media='all' />
	<!--[if lte IE 7]>
	<link rel='stylesheet' id='ie-css'  href='<?php echo get_bloginfo( 'url' );?>/wp-admin/css/ie.css?ver=20100610' type='text/css' media='all' />
	<![endif]--><?php
	
	c2pf_mes( 'Free Edition','I improve my plugins on a weekly basis but the best version is only provided when I am hired. Prices start at &pound;49.99 for 
			 hands on installation and project configuration support. <a href="http://www.csv2post.com">Read more</a>. Please remember to replace the AdSense
			 code in this plugin with your own.' );
} 
      
# Displays WTG Copyright And Provides Script For Post Boxes
function c2pf_footer()
{?>
	<script type="text/javascript"><!--
    google_ad_client = "ca-pub-4923567693678329";
    /* CSV 2 POST Free - Admin */
    google_ad_slot = "6336698412";
    google_ad_width = 468;
    google_ad_height = 15;
    //-->
    </script>
    <script type="text/javascript"
    src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
    </script>	
	
	<?php 
	$errordisplay = 1;
	if( $errordisplay == 1 )
	{
		$pro = get_option('c2pf_pro');
		if( isset( $pro['current'] ) &&  $pro['current'] != '' ){$csv = get_option( 'c2pf_'.$pro['current'] );}else{$csv = 'No Current Project Has Been Set';}
		
		$deb = get_option('c2pf_deb');
		$des = get_option('c2pf_des');
		$pat = get_option('c2pf_pat');
		$set = get_option('c2pf_set');
		$que = get_option('c2pf_que');
		$not = get_option('c2pf_not');
		$spe = get_option('c2pf_spe');
		$sni = get_option('c2pf_sni');?>
	
		<div class="wrap">
			<div id="poststuff" class="meta-box-sortables" style="position: relative; margin-top:10px;">
			
            <strong>The Panels Below Show Data From The Wordpress Options Table. They Are Being Displayed
            Because The Error Display Mode Is Activated From The Settings Page<br /><br /></strong>
            
 			<div class="postbox closed">
				<div class="handlediv" title="Click to toggle"><br /></div>
				<h3>Testing</h3>
				<div class="inside">
					<p>
					<?php
						echo '
						<p>This is testing and debugging related settings or results.</p>';	
						print "<pre>";
						print_r($deb);
						print "</pre>";		
					?>
					</p>
				</div>
			</div>	 			
            
            <div class="postbox closed">
				<div class="handlediv" title="Click to toggle"><br /></div>
				<h3>Directory/Paths</h3>
				<div class="inside">
					<p>
					<?php
						echo '
						<p>This is paths to data sources ($pat), mainly CSV files, store in the Wordpress option table.</p>';	
						print "<pre>";
						print_r($pat);
						print "</pre>";		
					?>
					</p>
				</div>
			</div>	
            					
 			<div class="postbox closed">
				<div class="handlediv" title="Click to toggle"><br /></div>
				<h3>HTML Snippets</h3>
				<div class="inside">
					<p>
					<?php
						echo '
						<p>HTML snippets .</p>';	
						print "<pre>";
						print_r($sni);
						print "</pre>";		
					?>
					</p>
				</div>
			</div>	
            		
 			<div class="postbox closed">
				<div class="handlediv" title="Click to toggle"><br /></div>
				<h3>CSV Profile</h3>
				<div class="inside">
					<p>
					<?php
						echo '
						<p>This is the format of your csv ($csv) file and the configuration it requires in order to work with ECI.</p>';	
						print "<pre>";
						print_r($csv);
						print "</pre>";		
					?>
					</p>
				</div>
			</div>
			
 			<div class="postbox closed">
				<div class="handlediv" title="Click to toggle"><br /></div>
				<h3>Project Progress</h3>
				<div class="inside">
					<p>
					<?php 
						echo '
						<p>The project data array ($pro) holds statistics regarding data imported,updated,posts created and posts updated.</p>';	
						print "<pre>";
						print_r($pro);
						print "</pre>";	
					?>
					</p>
				</div>
			</div>
			
 			<div class="postbox closed">
				<div class="handlediv" title="Click to toggle"><br /></div>
				<h3>WYSIWYG Designs</h3>
				<div class="inside">
					<p>
					<?php
						print "<pre>";
						print_r($des);
						print "</pre>";			
					?>
					</p>
				</div>
			</div>
			
 			<div class="postbox closed">
				<div class="handlediv" title="Click to toggle"><br /></div>
				<h3>Interface Configuration</h3>
				<div class="inside">
					<p>
					<?php
						echo '<p>You will find answers to the questions ($que) asked. The answers are used to configure the interface how you need it.</p>';	
						print "<pre>";
						print_r($que);
						print "</pre>";	
					?>
					</p>
				</div>
			</div>
			
 			<div class="postbox closed">
				<div class="handlediv" title="Click to toggle"><br /></div>
				<h3>Settings</h3>
				<div class="inside">
					<p>
					<?php
						echo '<p>These are the global ($set) CSV 2 POST settings which effect all projects and plugin operations.</p>';	
						print "<pre>";
						print_r($set);
						print "</pre>";	
					?>
					</p>
				</div>
			</div>
			
 			<div class="postbox closed">
				<div class="handlediv" title="Click to toggle"><br /></div>
				<h3>Notifications</h3>
				<div class="inside">
					<p>
					<?php
						echo '<p>The plugins notification ($nots) messages are found in this array.</p>';		
						print "<pre>";
						print_r($not);
						print "</pre>";			
					?>
					</p>
				</div>
			</div>
			
 			<div class="postbox closed">
				<div class="handlediv" title="Click to toggle"><br /></div>
				<h3>Event Speed Profiles</h3>
				<div class="inside">
					<p>
					<?php
						echo '
						<p>The plugins configurations ($spe) are found in this array.</p>';		
						print "<pre>";
						print_r($spe);
						print "</pre>";			
					?>
					</p>	
				</div>
			</div>
			
		</div>
	</div><?php 	
	}
	?>
	
   <script type="text/javascript">
        // <![CDATA[
        jQuery('.postbox div.handlediv').click( function() { jQuery(jQuery(this).parent().get(0)).toggleClass('closed'); } );
        jQuery('.postbox h3').click( function() { jQuery(jQuery(this).parent().get(0)).toggleClass('closed'); } );
        jQuery('.postbox.close-me').each(function(){
        jQuery(this).addClass("closed");
        });
        //-->
    </script><?php 
}

# Counts Number of Special Functions Activated
function c2pf_countspecials( $filename )
{
	$csv = get_option( 'c2pf_'. $filename );
	$count = 0;
	// 1
	if( isset( $csv['specials']['col']['aioseokeywords_col'] ) && $csv['specials']['col']['aioseokeywords_col'] != 'NA' && $csv['specials']['state']['aioseokeywords_col'] == 'On' ){++$count;}
	// 2
	if( isset( $csv['specials']['col']['madetags_col'] )&& $csv['specials']['col']['madetags_col'] != 'NA'&& $csv['specials']['state']['madetags_col'] == 'On' ){++$count;}
	// 3
	if( isset( $csv['specials']['col']['thumbnail_col'] )&& $csv['specials']['col']['thumbnail_col'] != 'NA'&& $csv['specials']['state']['thumbnail_col'] == 'On' ){++$count;}
	// 4
	if( isset( $csv['specials']['col']['cloaking1_col'] )&& $csv['specials']['col']['cloaking1_col'] != 'NA'&& $csv['specials']['state']['cloaking1_col'] == 'On' ){++$count;}
	// 5
	if( isset( $csv['specials']['col']['permalink_col'] )&& $csv['specials']['col']['permalink_col'] != 'NA'&& $csv['specials']['state']['permalink_col'] == 'On' ){++$count;}
	// 6
	if( isset( $csv['specials']['col']['dates_col'] )&& $csv['specials']['col']['dates_col'] != 'NA'&& $csv['specials']['state']['dates_col'] == 'On' ){++$count;}
	// 7
	if( isset( $csv['specials']['col']['tags_col'] )&& $csv['specials']['col']['tags_col'] != 'NA'&& $csv['specials']['state']['tags_col'] == 'On' ){++$count;}
	// 8
	if( isset( $csv['specials']['col']['excerpt_col'] )&& $csv['specials']['col']['excerpt_col'] != 'NA'&& $csv['specials']['state']['excerpt_col'] == 'On' ){++$count;}
	// 9
	if( isset( $csv['specials']['col']['cats_col'] )&& $csv['specials']['col']['cats_col'] != 'NA'&& $csv['specials']['state']['cats_col'] == 'On' ){++$count;}
	return $count;
}

# Returns Number Of Custom Fields In Use ( Not NA )#
function c2pf_customfieldsinuse( $filename )
{
	$csv = get_option('c2pf_'.$filename);
	$total = 0;	
	if( isset( $csv['customfields'] ) )
	{
		foreach( $csv['customfields'] as $key => $column )
		{
			if( $column != 'NA' ){++$total;}
		}
	}
	return $total;
}

# Menu Of Condition Argument Options
function c2pf_conditionstypes( $filename )
{
	$csv = get_option( 'c2pf_'.$filename );
	echo '<select name="c2pf_type" size="1">';
	
	echo '<option value="content">Post Content</option>';
	echo '<option value="title">Post Title</option>';
	echo '<option value="titlecontent">Post Title &amp; Content</option>';
	echo '<option value="everything">Everything</option>';

	echo '</select>';
}

# Used On Categories Stage To Indicate The Users Current Setup
function c2pf_categoriesstatus()
{
	$pro = get_option( 'c2pf_pro' );
	$csv = get_option( 'c2pf_'.$pro['current'] );
	
	$status = '---- No Categories Setup';
	
	if( $pro )
	{
		// single category setup overrides all other settings
		if( isset( $csv['singlecategory'] ) && $csv['singlecategory'] != 'NA' )
		{
			$status = '---- Single Categories Activated';
		}
		else
		{
			// display number of category sets saved
			if( isset( $csv['categories'] ) && !isset( $csv['singlecategory'] ) 
			|| isset( $csv['singlecategory'] ) && $csv['singlecategory']  == 'NA' )
			{			
				$i = 0;
				foreach( $csv['categories'] as $set=>$c )
				{	
					++$i;
				}
				
				$status = '---- Category Sets Saved: '.$i;
			}
		}
	}
	
	echo $status;
}

# Returns Column Exclusion Status On Config Page
function c2pf_columnexclusionsstatus( $filename )
{
	$csv = get_option( 'c2pf_'.$filename );
	
	$c = 0;
	
	if( isset( $csv['updating']['exclusions'] ) )
	{
		foreach( $csv['updating']['exclusions'] as $key => $val )
		{
			if( $val == 'Exclude' )
			{
				++$c;
			}
		}
	}
				
	return ' ---- Excluded: ' . $c;
}

# Builds Drop Down Form Menu For Update Exclusions Form
function c2pf_exclusionmenu( $column, $filename )
{
	$csv = get_option( 'c2pf_'.$filename );
	
	$object = '<select name="c2pf_ex_'.$column.'" size="1">';
		
	if( isset( $csv['updating']['exclusions'][$column] ) && $csv['updating']['exclusions'][$column] == 'Include' ) {$selected = 'selected="selected"';}else{$selected = '';}
	
	$object .= '<option value="Include" '.$selected.'>Include</option>';

	if( isset( $csv['updating']['exclusions'][$column] ) && $csv['updating']['exclusions'][$column] == 'Exclude' ) {$selected = 'selected="selected"';}else{$selected = '';}
	
	$object .= '<option value="Exclude" '.$selected.'>Exclude</option>';
	
	$object .= '</select>';
	
	return $object;
}
?>