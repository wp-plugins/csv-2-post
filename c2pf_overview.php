<?php c2pf_header(); ?>       

<?php
global $wpdb;

// get data arrays before processing for the functions themselves
$pro = get_option('c2pf_pro');
$csv = get_option('c2pf_'.$pro['current']);
$set = get_option('c2pf_set');

// processing functions
if( isset( $_POST['c2pf_deletetable_submit'] ) )
{
	c2pf_deletetable( $pro['current'] );
}

if( isset( $_POST['c2pf_createtable_submit'] ) )
{
	c2pf_createtable( $pro['current'],$set );
}

if( isset( $_POST['c2pf_seperatorchange_form'] ) )
{
	$csv = get_option('c2pf_'.$pro['current']);
	$csv['format']['seperator'] = $_POST['c2pf_seperator'];
	$csv['format']['quote'] = stripslashes( $_POST['c2pf_quote'] );
	$csv['arraychange'] =  c2pf_arraychange( __LINE__,__FILE__ );

	if( update_option( 'c2pf_'.$pro['current'], $csv ) )
	{
		c2pf_mes( 'Seperator &amp; Quote Saved','Your project will now use the new values, please ensure they are correct by reviewing the tokens list on this screen. If each of your column titles are no on a new line it may indicate incorrect seperator being used.' );
	}
	else
	{
		c2pf_err( 'Seperator &amp; Quote Failed To Save','Wordpress coule not save the change to the options table at this time, please try again then seek support if the problem continues.' );
	}
}

// get data arrays after processing functions for this page
$pro = get_option('c2pf_pro');
$csv = get_option('c2pf_'.$pro['current']);
$set = get_option('c2pf_set');

if( !isset( $pro['current'] ) || $pro['current'] == '' || is_null( $pro['current'] ) )
{
	c2pf_mes('No Current Project','The plugin does not have a currently ongoing project. You must start a project on the Data Source page
	for anything to show on this page. Not having a current project yet may also trigger some interface related errors, please ignore them 
	at this time.');
}
else
{	
	$csv = get_option('c2pf_'. $pro['current'] );?>

	<div class="wrap">
	
		<h2>CSV 2 POST Project Overview</h2>
		<h2>For <?php echo $pro['current'];?></h2>
					
		<div id="dashboard-widgets-wrap">
			<div id="dashboard-widgets" class="metabox-holder">
	
				<!-- BEGINNING OF PAGE WIDE POST BOXES -->
				<div class="wrap">
					<div id="poststuff" class="meta-box-sortables" style="position: relative; margin-top:10px;">
					
						<div class="postbox closed">
							<div class="handlediv" title="Click to toggle"><br /></div>
							<h3>Project SQL Queries</h3>
							<div class="inside">
                            	<h4>Pre-prepared Insert Query</h4>
								<form>
									<textarea rows="10" cols="78"><?php if( isset(  $csv['sql']['insertstart'] ) ){echo $csv['sql']['insertstart'];} ?></textarea> 
								</form>  
                      			<br />
                      			<br />
                            	<h4>Last Insert Query Used</h4>
								<form>
									<textarea rows="10" cols="78"><?php if( isset(  $csv['sql']['lastinsert'] ) ){echo $csv['sql']['lastinsert'];} ?></textarea> 
								</form>  
                      			<br />
                      			<br />
                            	<h4>Last Update Query Used</h4>
								<form>
									<textarea rows="10" cols="78"><?php if( isset(  $csv['sql']['lastupdate'] ) ){echo $csv['sql']['lastupdate'];} ?></textarea> 
								</form>  
							</div>
						</div>
					
					</div>
				</div>				
			
			
				<div class='postbox-container' style='width:49%;'>
					<div id="normal-sortables" class="meta-box-sortables">	
					
					
						<!-- START OF BOX -->
						<div id="dashboard_right_now" class="postbox" >
							<div class="handlediv" title="Click to toggle"><br /></div>
							
							<h3 class='hndle'><span>CSV File Format</span></h3>
							<div class="inside">
								<div class="table table_content">
									<p class="sub">Change Seperator</p>
															
									<table>
										<tr class="first">
											<td class="first b b-posts"><a href='#'>Seperator:</a></td>
											<td class="t posts"><a href='#'><?php echo $csv['format']['seperator'];?></a>
									</td>
										</tr>
										<tr>
											<td class="first b b-posts"><a href='#'>Quote:</a></td>
											<td class="t posts"><a href='#'><?php echo $csv['format']['quote'];?></a></td>
										</tr>
										<tr>
											<td class="first b b-posts"><a href='#'>Columns:</a></td>
											<td class="t posts"><a href='#'><?php echo $csv['format']['columns'];?></a></td>
										</tr>
									</table>
								</div>
														
								<div class="versions">   	
									<form method="post" name="c2pf_seperatorchange_form" action="">  
										<select name="c2pf_seperator" size="1">
											<option value=",">Comma (,)</option>					
											<option value=";">Semi-Colon (;)</option>
											<option value=":">Colon (:)</option>
											<option value="|">Tab (|)</option>
										</select> 
                                        <br />
                                        <select name="c2pf_quote" size="1">
											<option value='"'>"</option>
											<option value="'">'</option>
										</select>

										<input name="c2pf_csvfile" type="hidden" value="estorewithpages" /><input class="button-primary" type="submit" name="c2pf_seperatorchange_form" value="Save" />     
										
									</form>   								
                                    <br class="clear" />
								</div>
								
							</div>
						</div>
						<!-- END OF BOX -->
		
						<!-- START OF BOX -->
						<div id="dashboard_right_now" class="postbox" >
							<div class="handlediv" title="Click to toggle"><br /></div>
							
							<h3 class='hndle'><span>Configuration</span></h3>
							<div class="inside">
								<div class="table table_content">
									<p class="sub">View Help</p>
															
									<table>
										<tr class="first">
											<td class="first b b-posts"><a href='#'>Created:</a></td>
											<td class="t posts"><a href=''><?php echo date("M j, Y, g:i a",$pro[$pro['current']]['created']);?></a>
											</td>
										</tr>
                                        
										<tr>
											<td class="first b b-posts"><a href='#'>Path:</a></td>
											<td class="t posts"><a href='#' title="<?php echo $pro[$pro['current']]['filepath'];?>">View Path</a></td>
										</tr>
                                        
										<tr>
											<td class="first b b-posts"><a href='#'>Speed Profile Name:</a></td>
											<td class="t posts">
                                                <a href='#'>
													<?php 
													if( isset( $pro[$pro['current']]['speed'] ) )
													{
                                                    	echo $pro[$pro['current']]['speed'];
													}
													else
													{
														echo 'Not Set';
													}
													?>
                                                </a>
                                            </td>
										</tr>										
                                        
                                        <tr>
											<td class="first b b-posts"><a href='#'>Speed Profile Type:</a></td>
											<td class="t posts">
                                                <a href='#'>
													<?php 
													if( isset( $spe[ $pro[$pro['current']]['speed'] ]['type'] ) )
													{
                                                    	echo $spe[ $pro[$pro['current']]['speed'] ]['type'];
													}
													else
													{
														echo 'Not Set';
													}
													?>
                                                </a>
                                            </td>
										</tr>
                                        
                                        <?php
										##############   ONLY DISPLAY ACTIVE OR PAUSED STATUS IF SPREADOUT SPEED PROFILE    #####################
										?>
                                        
										<tr>
											<td class="first b b-posts"><a href='#'>Status:</a></td>
											<td class="t posts"><a href='#'><?php echo $pro[ $pro['current'] ]['status'];?></a></td>
										</tr>
                                        
									</table>
								</div>
														
								<div class="versions">   	
										<br class="clear" />
								</div>
								
							</div>
						</div>
						<!-- END OF BOX -->
							
                            
						<!-- START OF BOX -->
						<div id="dashboard_right_now" class="postbox" >
							<div class="handlediv" title="Click to toggle"><br /></div>
							
							<h3 class='hndle'><span>Project Database Table</span></h3>
							<div class="inside">
								<div class="table table_content">
									<p class="sub">View Help</p>
									<table>
										<tr class="first">
											<td class="first b b-posts"><a href='#'>Table Created:</a></td>
											<td class="t posts">
                                                <form method="post" name="c2pf_projecttable_form" action=""> 
													<?php 
                                                    if( c2pf_istable( $pro['current'] ) )
                                                    { 
                                                        echo '<input class="button-primary" type="submit" name="c2pf_deletetable_submit" value="Yes, Delete Table" />'; 
                                                    }
                                                    else
                                                    { 
                                                        echo '<input class="button-primary" type="submit" name="c2pf_createtable_submit" value="No, Create Table" />'; 
													}
                                                    ?>
                                                </form>
                                            </td>
										</tr>
                                        
										<tr class="first">
											<td class="first b b-posts"><a href='#'>Table Name:</a></td>
											<td class="t posts"><a href='#'><?php echo $csv['sql']['tablename']; ?></a></td>
										</tr>										
                                        
                                        <tr class="first">
											<td class="first b b-posts"><a href='#'>Column Names</a></td>
											<td class="t posts"><a href='#'></a></td>
										</tr>

										<?php
										$query = "SHOW COLUMNS FROM " . $csv['sql']['tablename'];
										$rs = mysql_query($query);
										$i = 0;
										
										if( $rs )
										{
										
											while ($row = mysql_fetch_array($rs)) 
											{
												?>
												<tr class="first">
													<td class="first b b-posts"><a href='#'><?php echo $i; ?></a></td>
													<td class="t posts"><a href='#'><?php echo $row[0]; ?></a></td>
												</tr>
											<?php 
												++$i;
											}
										}
                                        ?>
        
									</table>
								</div>
														
								<div class="versions">   	
										<br class="clear" />
								</div>
								
							</div>
						</div>
						<!-- END OF BOX -->
                        
                                                   
                            			
					</div>	
				</div>
		
				<!-- LEFT COLUMN START -->
				
				<div class='postbox-container' style='width:49%;'>
					<div id="side-sortables" class="meta-box-sortables">
		
		
		
						<!-- START OF BOX -->
						<div id="dashboard_right_now" class="postbox" >
							<div class="handlediv" title="Click to toggle"><br /></div>
							
							<h3 class='hndle'><span>Progress</span></h3>
							<div class="inside">
								<div class="table table_content">
									<p class="sub">View Help</p>
									<table>
										<tr class="first">
											<td class="first b b-posts"><a href='#'>Posts Created:</a></td>
											<td class="t posts"><a href=''><?php echo $pro[$pro['current']]['postscreated'];?></a></td>
										</tr>
										<tr>
											<td class="first b b-posts"><a href='#'>Posts Updated:</a></td>
											<td class="t posts"><a href=''><?php echo $pro[$pro['current']]['postsupdated'];?></a></td>
										</tr>
										<tr>
											<td class="first b b-posts"><a href='#'>Categories Created:</a></td>
											<td class="t posts"><a href=''><?php echo $pro[$pro['current']]['catscreated'];?></a></td>
										</tr>
										<tr>
											<td class="first b b-posts"><a href='#'>Tags Created:</a></td>
											<td class="t posts"><a href=''><?php echo $pro[$pro['current']]['tagscreated'];?></a></td>
										</tr>								
									</table>
								</div>
														
								<div class="versions">   	
										<br class="clear" />
								</div>
								
							</div>
						</div>
						<!-- END OF BOX -->			
		
		
						<!-- START OF BOX -->
						<div id="dashboard_right_now" class="postbox" >
							<div class="handlediv" title="Click to toggle"><br /></div>
							
							<h3 class='hndle'><span>Design Tokens</span></h3>
                            
							<div class="inside">
								<div class="table table_content">
									<p class="sub">View Help</p>
									<?php c2pf_displaytokenlist( 'tokens' ); ?>
								</div>
								<div class="versions">						
									<br class="clear" />
								</div>
							</div>
                            
						</div>
						<!-- END OF BOX -->
							
                        <!-- START OF BOX -->
                       <div class="postbox">
                            <div class="handlediv" title="Click to toggle"><br /></div>
                            <h3>Current Project Shortcodes</h3>
                            <div class="inside">
                            <?php c2pf_displaytokenlist('shortcodes'); ?>
                            </div>
                        </div>  
                        <!-- END OF BOX -->				
								
					<!-- END OF COLUMN -->			
					</div>	
				</div>
			</div>
	
		<div class="clear"></div>
		</div><!-- dashboard-widgets-wrap -->
	</div><!-- wrap -->
	
	
		
<?php
}
?>

<?php c2pf_footer(); ?>