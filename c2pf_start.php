<?php c2pf_header();?>       

<?php
// get data arrays before processing functions
$pro = get_option('c2pf_pro');
$set = get_option('c2pf_set');
		
// list of processing functions
if( isset( $_POST['c2pf_newproject_submit'] ) )
{
	c2pf_newproject( $_POST['c2pf_filepath'],$set );
}		

// delete csv file
if( isset( $_POST['c2pf_newproject_deletefile_submit'] ) )
{
	c2pf_deletecsvfile( $_POST['c2pf_filepath'],$set );
}		

// processing request to delete project
if( isset( $_POST['c2pf_deleteproject_submit'] ) ) 
{ 
	c2pf_deleteproject( $_POST['c2pf_filename'] );
}

// change current project submission
if( isset( $_POST['c2pf_currentproject_submit'] ) ) 
{
	c2pf_changecurrentproject( $_POST['c2pf_filename'] );
}

// upload csv file
if( isset( $_POST['c2pf_csvupload_submit'] ) )
{
	c2pf_csvupload( $_FILES['file'],$set );
}   
	
// create folder and save path as csv file directory
if( isset( $_POST['c2pf_createdirectory_submit'] ) )
{
	c2pf_createdirectory( $_POST['c2pf_pathname'],$_POST['c2pf_pathdir'] );		
}

// save existing folder path as new csv file directory
if( isset( $_POST['c2pf_createdirectory_submit'] ) )
{
	c2pf_savedirectory( $_POST['c2pf_pathname'],$_POST['c2pf_pathdir'] );		
}

// delete or remove directory
if( isset( $_POST['c2pf_undodirectory_submit'] ) )
{
	c2pf_undodirectory( $_POST['c2pf_path'],$_POST['c2pf_action'] );		
}                    

# Opens And Prints Contents Of CSV File To Screen
function c2pf_printcsv( $path,$set,$separator,$quote )
{	
	if ( !file_exists( $path ) ) 
	{
		c2pf_mes( 'CSV File Not Found','The plugin could not locate the selected csv file. Here is the path used: '.$path );
	}
	else
	{
		echo '<h2>CSV File View and Test</h2>';
		echo '<strong>You Are Viewing: '.$path.'</strong><br /><br />';
		
		c2pf_pearcsv_include();
	
		// csv file row counter
		$rows = 0;
	
		// use pear to read csv file
		$conf = File_CSV::discoverFormat( $path );
		
		// apply seperator
		$conf['sep'] = $separator;	
		
		// apply quote
		$conf['quote'] = $quote;
		
		// build header of table by looping through records but using the first row only
		while ( ( $r = File_CSV::read( $path,$conf ) ) ) 
		{				
			// start table header
			$table = '<table class="widefat post fixed">
			<tr>';
			
			for ( $i = 0; $i < $conf['fields']; $i++ )
			{
				$table .= '<td>'.$r[$i].'</td>';
			}
			
			// end table header
			$table .= '</tr>';			
						
			if( $rows != 0 )
			{
				echo '<tr>';
				echo '<td>'.$entry.'</td>';
				echo '<td>'.$r[0].'</td>';
				echo '<td>'.$r[1].'</td>';
				echo '<td>'.$r[2].'</td>';
				echo '<td>'.$r[3].'</td>';
				echo '<td>'.$r[4].'</td>';
				echo '</tr>';
				
				++$entry;
			}
			break;
		}
		
		$entry = 1;
		
		// loop through records until speed profiles limit is reached then do exit
		while ( ( $r = File_CSV::read( $path,$conf ) ) ) 
		{	
			if( $rows != 0 )
			{
				
				$table .=  '<tr>';

				for ( $d = 0; $d < $conf['fields']; $d++ )
				{
					$table .= '<td>'.$r[$d].'</td>';
				}

				$table .=  '</tr>';
				
				++$entry;
			}
			
			++$rows;
		}
		
		$table .=  '</table>';
		echo $table;
	}
}

// view csv files contents by printing to screen
if( isset( $_POST['c2pf_printcsv_submit'] ) )
{
	c2pf_printcsv( $_POST['c2pf_filepath'],$set,$_POST['c2pf_seperator'], stripslashes( $_POST['c2pf_quote'] ) );		
}                    
                    
// get data array after processing functions
$pro = get_option('c2pf_pro');
?>

<div class="wrap">

	<h2>CSV 2 POST Start Projects</h2>
				
	<div id="dashboard-widgets-wrap">
		<div id="dashboard-widgets" class="metabox-holder">
	
			<div id="dashboard_right_now" class="postbox closed" >
                <div class="handlediv" title="Click to toggle"><br /></div>
                <h3>Create New Project</h3>
                <div class="inside">
					<form method="post" name="c2pf_newproject_form" action=""> 
                    
                        <h4>Select Datasource</h4>
                		<?php c2pf_csvfilelist_newproject( $set ); ?>

                        <br />
                        <br />

                        <h4>Also Select Event Speed Profile (only manual events methods in free edition)</h4>
						<?php c2pf_speedprofilelist(); ?>
                        
                        <br />

                        <div class="versions">
                            <p><input class="button-primary" type="submit" name="c2pf_newproject_submit" value="Create" />
                            <input class="button-primary" type="submit" name="c2pf_newproject_deletefile_submit" value="Delete File" /></p>
                            <br class="clear" />
                        </div>	
                        
                     </form>  
	
                </div>
            </div>


			<div id="dashboard_right_now" class="postbox closed" >
                <div class="handlediv" title="Click to toggle"><br /></div>
                <h3>Manage Data Sources</h3>
                <div class="inside">
                    <h4>Upload CSV File <?php echo ini_get( "upload_max_filesize").'B Limit';?><h4>
                   	<form method="post" enctype="multipart/form-data" name="uploadform" class="form-table">
                   		<input type="file" name="file" size="70" /><br /><br />
						<?php c2pf_pathsmenu(); ?>
                   		<input class="button-primary" type="submit" value="Upload CSV File" name="c2pf_csvupload_submit" />
                    </form>                   
                    <br /><br /><br /><br />
                    <h4>Add Or Create New CSV File Directory</h4><br />
					<form method="post" name="c2pf_directory_form" action="">  
                        <input name="c2pf_pathdir" type="text" value="<?php echo WP_CONTENT_DIR; ?>" size="100" maxlength="100" disabled="disabled" /> <br /><br />
                        <input name="c2pf_pathname" type="text" value="Name" size="12" maxlength="12" disabled="disabled" />      <br /><br />
                   		<input class="button-primary" type="submit" value="Save Existing Directory" name="c2pf_savedirectory_submit" disabled="disabled" />
                   		<input class="button-primary" type="submit" value="Create New Directory" name="c2pf_createdirectory_submit" disabled="disabled" />
                    </form>    
                    <br /><br /><br /><br />
                    <h4>Remove Or Delete CSV File Directory</h4><br />
					<form method="post" name="c2pf_undodirectory_form" action="">  
						<?php c2pf_pathsmenu(); ?>
                        <br /><br />
						<select name="c2pf_action">
							<option value="remove">Remove Directory From Plugin </option>
							<option value="delete">Delete Directory And Contents From Server</option>
                        </select><br /><br />                        
                   		<input class="button-primary" type="submit" value="Submit" name="c2pf_undodirectory_submit" disabled="disabled" />
                    </form>    
                    <br /><br /><br />
                </div>
            </div>		
    

			<div id="dashboard_right_now" class="postbox closed" >
                <div class="handlediv" title="Click to toggle"><br /></div>
                <h3>View &amp; Test Files</h3>
                <div class="inside">
                	For now this is a basic tool that allows you to display a csv files contents within a table. Beware of opening large
                    files as it prints the entire content to this page. Until further improvements are made it is intended to aid testing of
                    new csv files.
                    <br />
                    <br />
					<form method="post" name="c2pf_printcsv_form" action=""> 
                    
                        <h4>Select Datasource</h4>
                		<?php c2pf_csvfilelist_newproject( $set ); ?>

                        <br />
                        <br />

                        <h4>Select Test Separator</h4>
                                <select name="c2pf_seperator" size="1">
                                    <option value=";">Semi-Colon (;)</option>
                                    <option value=":">Colon (:)</option>
                                    <option value=",">Comma (,)</option>					
                                    <option value="|">Tab (|)</option>
                                </select>
                            <br class="clear" />
                            
                        <h4>Select Test Quote</h4>
                                <select name="c2pf_quote" size="1">
                                    <option value="'">'</option>
                                    <option value='"'>"</option>
                                </select>
                            <br class="clear" />

                        <div class="versions">
                            <p><input class="button-primary" type="submit" name="c2pf_printcsv_submit" value="Open" /></p>
                            <br class="clear" />
                        </div>	
                        
                     </form>  
	
                </div>
            </div>


        <h2>History Of All Projects Below</h2>

                <?php
				// list existing projecta each one with their own post box
				if( isset( $pro ) && $pro != '' )
				{
					foreach( $pro as $key=>$item )
					{
						if( $key != 'arraydesc' && $key != 'current' && $key != 'records' )
						{
							// close all post boxes apart from the current project
							if( $pro['current'] == $key )
							{
								$postbox = '';
								$label = ' (current project)';
							}
							else
							{
								$postbox = 'closed';
								$label = '';
							}
							?>
							<div id="dashboard_right_now" class="postbox <?php echo $postbox; ?>" >
								<div class="handlediv" title="Click to toggle"><br /></div>
								
								<h3 class='hndle'><span><?php echo $key . ' ' . $label; ?></span></h3>
								<div class="inside">
									<div class="table table_content">
										<p class="sub">Generated</p>
										<table>
											<tr class="first">
												<td class="first b b-posts"><a href='#'><?php echo $item['postscreated'];?></a></td>
												<td class="t posts"><a href='#'>Posts</a> Created </td>
											</tr>
											<tr>
												<td class="first b b_pages"><a href='#'><?php echo $item['postsupdated'];?></a></td>
												<td class="t pages"><a href='#'>Posts</a> Updated</td>
											</tr>			
											<tr>
												<td class="first b b-cats"><a href='#'><?php echo $item['catscreated'];?></a></td>
												<td class="t cats"><a href='#'>Categories Created</a></td>
											</tr>
											<tr>
												<td class="first b b-tags"><a href='#'><?php echo $item['tagscreated'];?></a></td>
												<td class="t tags"><a href='#'>Tags Created</a></td>
											</tr>
										</table>
										
                                        <br />
                                        <br />
                                        <h4>Data Statistics</h4>
                                        
										<table>
                                            <tr>
												<td class="first b b-tags"><a href='#'><?php echo $item['rowsinsertsuccess'];?></a></td>
												<td class="t tags"><a href='#'>Rows Successfully Inserted</a></td>
											</tr>
											<tr>
												<td class="first b b-tags"><a href='#'><?php echo $item['rowsinsertfail'];?></a></td>
												<td class="t tags"><a href='#'>Rows Failed To Insert</a></td>
											</tr>
										</table>
									</div>
									
									<div class="table table_discussion">
										<p class="sub">Admin</p>
										<table>
											<tr class="first"><td class="b b-comments"><a href="edit-comments.php"><span class="total-count">0</span></a></td>
											<td class="last t comments"><a href="edit-comments.php">Outdated</a></td>
											</tr>
											<tr><td class="b b_approved"><a href='edit-comments.php?comment_status=approved'><span class="approved-count">0</span></a></td>
											<td class="last t"><a class='approved' href='edit-comments.php?comment_status=approved'>Milestones</a></td>
											</tr>
											<tr>
                                            	<td class="b b-waiting"><a href='edit-comments.php?comment_status=moderated'><span class="pending-count">0</span></a></td>
												<td class="last t"><a class='waiting' href='edit-comments.php?comment_status=moderated'>Duplicates</a></td>
											</tr>
											<tr>
                                            	<td class="b b-spam"><a href='edit-comments.php?comment_status=spam'><span class='spam-count'>0</span></a></td>
												<td class="last t"><a class='spam' href='edit-comments.php?comment_status=spam'>Flagged</a></td>
											</tr>
											<tr>
                                            	<td class="b b-spam"><a href='edit-comments.php?comment_status=spam'><span class='spam-count'>0</span></a></td>
												<td class="last t"><a class='spam' href='edit-comments.php?comment_status=spam'>Past Events</a></td>
											</tr>
										</table>
									</div>
				
									<div class="versions">
										<form method="post" name="c2pf_estoreproject_withpages_form" action="">  
											<input name="c2pf_projecttype" type="hidden" value="estorewithpages" />     
											<input name="c2pf_filename" type="hidden" value="<?php echo $key; ?>" />     
											<br />                 
                                                                                        
											<?php ########## TO BE COMPLETE WHEN SCHEDULING IS ADDED
											/*
                                            <input class="button-primary" type="submit" name="c2pf_enableproject_submit" value="Pause" />
											<input class="button-primary" type="submit" name="c2pf_disableproject_submit" value="Continue" />
                                            */?>
                                            
                                            <a href="admin.php?page=c2pf_configs&amp;changecurrent=<?php echo $key;?>" class="button-primary" title="Configure Project">Open</a>
											<input class="button-primary" type="submit" name="c2pf_deleteproject_submit" value="Delete" />
											<input class="button-primary" type="submit" name="c2pf_recheck_submit" value="Force Re-Check" disabled />
										</form>   							
										<br class="clear" />
									</div>
									
								</div>
							</div><?php
						}// end is
					}// end of loop each $pro
				}// end of is set $pro
                ?>


<div class="clear"></div>
</div><!-- dashboard-widgets-wrap -->

</div><!-- wrap -->

<?php c2pf_footer(); ?>

